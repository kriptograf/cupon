<?php

class UloginController extends Controller
{

    public function actionLogin()
    {

        //echo CVarDumper::dump(Yii::app()->user->returnUrl,10,true);exit;

        if(!Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->user->returnUrl);
        }
        //echo CVarDumper::dump($_POST,10, true);exit;
        //Здесь в post имеем только токен
        /**
         * Если пришел какой то токен постом
         */
        if (isset($_POST['token']))
        {
            /**
             * Создаем объект модели единой авторизации
             */
            $ulogin = new UloginModel();
            //echo CVarDumper::dump($_POST,10, true);exit;
            /**
             * Зполняем свойства модели
             */
            $ulogin->setAttributes($_POST);
            //echo CVarDumper::dump($ulogin->getAttributes(),10, true);exit;

            //наданном шаге известен только токен
            /**
             * Получаем аутентификационные данные
             */
            $ulogin->getAuthData();
            //echo CVarDumper::dump($ulogin->getAuthData(),10, true);exit;
            //ТУТ НУЛЛ ПОЧЕМУТО
            /**
             * Если авторизация пройдена успешно, редиректим на главную
             */
            if($ulogin->validate())
            {
                //echo 'пройдена валидация';
                //echo CVarDumper::dump($ulogin->getErrors(),10, true);
                //echo CVarDumper::dump($ulogin,10, true);
                //exit;
                if ($ulogin->login())
                {
                    Yii::app()->user->setFlash('message','Поздравляем,Вы успешно вошли в систему.');
                    //echo CVarDumper::dump($ulogin,10, true);exit;
                    $this->redirect(Yii::app()->homeUrl);
                }
                else
                {
                    //echo 'не залогинился';
                    //echo CVarDumper::dump($ulogin->getErrors(),10, true);
                    //echo CVarDumper::dump($ulogin,10, true);
                    //exit;
                    Yii::app()->user->setFlash('message','Произошла ошибка при входе через сервис социальных сетей. Попробуйте еще раз.');
                    /**
                     * В противном случае выводим ошибку авторизации
                     */
                    //$this->render('error');
                    $this->redirect(Yii::app()->homeUrl);
                }
            }
            else
            {
                //echo 'Не пройдена валидация';
                //echo CVarDumper::dump($ulogin->getErrors(),10, true);
                //echo CVarDumper::dump($ulogin,10, true);exit;
                Yii::app()->user->setFlash('message','Произошла ошибка при входе через сервис социальных сетей. Попробуйте еще раз.');
                /**
                 * В противном случае выводим ошибку авторизации
                 */
                //$this->render('error');
                $this->redirect(Yii::app()->homeUrl);
            }
        }
        else
        {

            $this->redirect(Yii::app()->homeUrl, true);
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}