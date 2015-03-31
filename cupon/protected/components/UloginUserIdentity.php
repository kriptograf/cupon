<?php

class UloginUserIdentity implements IUserIdentity
{

    private $id;
    private $name;
    private $isAuthenticated = false;
    private $states = array();

    public function __construct()
    {
    }

    public function authenticate($uloginModel = null)
    {
        //echo CVarDumper::dump($uloginModel, 10, true);exit;
        /**
         * Параметры для выборки пользователя по соцсети
         */
        $criteria = new CDbCriteria;
        $criteria->condition = 'identity=:identity AND network=:network';
        $criteria->params = array(
            ':identity' => $uloginModel->identity
        , ':network' => $uloginModel->network
        );
        $user = User::model()->find($criteria);

        //echo CVarDumper::dump($user, 10, true);exit;

        /**
         * Если такой пользователь уже есть
         * авторизуем его
         */
        if(null !== $user)
        {
            $profile = Profile::model()->findByPk($user->id);
            if (null !== $profile)
            {
                $this->id = $user->id;
                $this->name = $user->profile->fio;
            }
            else
            {
                /**
                 * Если у юзера нет профиля по каким то причинам
                 * создаем ему профиль
                 */
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->fio = $uloginModel->full_name;
                $profile->birthday = '1970-01-01';
                if($profile->save())
                {
                    $this->id = $user->id;
                    $this->name = $uloginModel->full_name;
                }
                else
                {
                    //echo CVarDumper::dump($profile->attributes,10,true);
                    //echo CVarDumper::dump($profile->getErrors(),10,true);
                    //echo 'Не смогли сохранить профиль';exit;
                    $deluser = User::model()->findByPk($user->id);
                    $deluser->delete();
                    Yii::app()->user->setFlash('message','Произошла ошибка при входе через сервис социальных сетей. Были предоставлены не точные данные. Попробуйте войти позже или воспользуйтесь стандартной формой входа.');
                    // echo CVarDumper::dump($profile->getErrors(),10,true);exit;
                    //$this->redirect(Yii::app()->homeUrl);
                    $this->isAuthenticated = false;
                    return false;
                }
            }

        }
        else
        {
            /**
             * Возможна ситуация, что пользователь регистрировался через
             * стандартную форму регистрации и у него еще нет идентификатора соцсети
             */
            $user = User::model()->findByAttributes(array('email'=>$uloginModel->email));
            if(null !== $user)
            {
                $profile = Profile::model()->findByPk($user->id);
                if (null !== $profile)
                {
                    $user->identity = $uloginModel->identity;
                    $user->network = $uloginModel->network;
                    if($user->save())
                    {
                        $this->id = $user->id;
                        $this->name = $user->profile->fio;
                    }

                }
                else
                {
                    /**
                     * Если у юзера нет профиля по каким то причинам
                     * создаем ему профиль
                     */
                    $profile = new Profile();
                    $profile->user_id = $user->id;
                    $profile->fio = $uloginModel->full_name;
                    $profile->birthday = '1970-01-01';
                    $user->identity = $uloginModel->identity;
                    $user->network = $uloginModel->network;
                    if($user->save())
                    {
                        if($profile->save())
                        {
                            $this->id = $user->id;
                            $this->name = $uloginModel->full_name;
                        }
                    }

                }
            }
            else
            {
                /**
                 * Создаем нового пользователя со всеми причитающимися
                 * ему атрибутами
                 */
                $user = new User();
                $profile = new Profile();

                $user->username = $uloginModel->email;
                $password = substr(md5(microtime()), 0, 8);
                $user->password = UserModule::encrypting($password);
                $user->activkey = UserModule::encrypting(microtime().$password);
                $user->identity = $uloginModel->identity;
                $user->network = $uloginModel->network;
                $user->email = $uloginModel->email;
                $user->superuser = 0;
                $user->status=1;

                //echo CVarDumper::dump($uloginModel->full_name,10,true);exit;
                if($user->save())
                {
                    $profile->user_id = $user->id;
                    $profile->fio = $uloginModel->full_name;
                    $profile->birthday = '1970-01-01';
                    //echo CVarDumper::dump($profile->attributes,10,true);exit;
                    if($profile->save())
                    {
                        /**
                         * После успешного создания юзера и создания его профиля
                         * Отправляем ему письмо на почту с учетными данными
                         */
                        UserModule::sendMail(
                            $user->email,
                            "Вам создан аккаунт на сайте ".Yii::app()->name,
                            "Вы можете входить через свой аккаунт $user->network\n\r"
                                ." Или через форму входа на сайте используя\n\r"
                                ." Имя пользователя: $user->email\n\r"
                                ." Пароль: $password"
                        );
                        $this->id = $user->id;
                        $this->name = $profile->fio;
                    }
                    else
                    {
                        Yii::app()->user->setFlash('message','Произошла ошибка при входе через сервис социальных сетей. Были предоставлены не точные данные. Попробуйте войти позже или воспользуйтесь стандартной формой регистрации.');
                        //echo CVarDumper::dump($profile->getErrors(),10,true);exit;
                        $this->isAuthenticated = false;
                        return false;
                    }


                }
                else
                {
                    Yii::app()->user->setFlash('message','Произошла ошибка при входе через сервис социальных сетей. Были предоставлены не точные данные. Попробуйте войти позже или воспользуйтесь стандартной формой регистрации.');
                    //echo CVarDumper::dump($user->getErrors(),10,true);exit;
                    $this->isAuthenticated = false;
                    return false;
                }
            }

        }
        $this->isAuthenticated = true;
        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsAuthenticated()
    {
        return $this->isAuthenticated;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPersistentStates()
    {
        return $this->states;
    }
}