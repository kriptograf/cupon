<?php

class CompaniesController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            'ajaxOnly + checkuser',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('create', 'index', 'view', 'checkuser', 'rating'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'update',
                    'updateLogo',
                    'updateAddress',
                    'updatePhones',
                    'updateSchedule',
                    'updateLink',
                    'updateVideo',
                    'updateGallery',
                    'updateDescription',
                    'updateNews',
                ),
                'users' => array('@'),
            ),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        Yii::app()->clientScript->registerScriptFile('/js/jquery.equal-height-columns.js',  CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile('/js/jquery.pikachoose.min.js',  CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile('/js/jquery.fancybox-1.3.4.pack.js',  CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile('/css/base.css');
        Yii::app()->clientScript->registerCssFile('/css/jquery.fancybox-1.3.4.css');


        $model = Companies::model()->find('id = '.$id.' AND checked=1 AND status=1');//$this->loadModel($id);
        if(!$model)
        {
           throw new CHttpException(404, 'The requested page does not exist.');
        }

        /**
         * Ставим куку на 12 часов, что пользователь уже просматривал эту компанию
         */
        $cookie = Yii::app()->request->cookies['view'.$id]->value;
        if(!isset($cookie) && $cookie!=1)
        {
            $cookie = new CHttpCookie('view'.$id, 1);
            $cookie->expire = time()+60*60*12;
            Yii::app()->request->cookies['view'.$id] = $cookie;
            $model->views = $model->views+1;
            if(!$model->save())
            {
                echo CVarDumper::dump($model->getErrors(),10,true);
            }
        }

        
        Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=AGLsdFEBAAAAC9QZNQIAeghrEX7jQPsHXcF5cNoaYEptcaIAAAAAAAAAAADcC_MkSuCqqL1mg95BzG34yrEo_w==', CClientScript::POS_HEAD);
        //Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU', CClientScript::POS_HEAD);

        $categories = CategoriesCompany::model()->findByPk($id);

        $gallery = Gallery::model()->findAll('company_id = ' . $id);

        $this->render('view', array(
            'model' => $model,
            'categories' => $categories,
            'gallery' => $gallery,
        ));
    }

    public function actionRating()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            /**
             * Проверка что юзер уже голосовал
             */
            $record = CompaniesRating::model()->findByAttributes(array(
                'user_id'=>  Yii::app()->user->id,
                'company_id'=>Yii::app()->request->getPost('id'),
                ));
            
            if($record)
            {
                 //отдаем ответ браузеру пользователя в формате json
                    echo CJSON::encode(array(
                        'status' => 'ERR',
                        'msg' => 'Вы уже голосовали за эту компанию',
                    ));
                    Yii::app()->end();
            }
            
            /**
             * время жизни кук в секундах (сейчас установлено 31 день)
             */
            $expires = time() + 3600 * 24 * 31;

            /**
             * если получили данны от пользователя методом пост
             */
            if (Yii::app()->request->getPost('rate') && Yii::app()->request->getPost('id'))
            {

                /**
                 * забираем из массива пост айди купона
                 */
                $company_id = Yii::app()->request->getPost('id');

                //задаем имя куки
                $cookie_name = 'company_' . $company_id;

                //проверяем есть ли значение в куке, если есть отдаем код ошибки и сообощение
                if (Yii::app()->request->cookies[$cookie_name]->value)
                {
                    //отдаем ответ браузеру пользователя в формате json
                    echo CJSON::encode(array(
                        'status' => 'ERR',
                        'msg' => 'Вы уже голосовали за эту компанию!',
                    ));
                }
                else
                {
                    //echo CVarDumper::dump('нет куки', 10, true);exit;
                    //Если кука не записана обрабатываем запрос
                    $model = Companies::model()->findByPk($company_id);

                    $this->performAjaxValidation($model);

                    //берем значение голосования из массива пост
                    $score = Yii::app()->request->getPost('rate');

                    //вычисляем рейтинг компании
                    $model->vote += $score;

                    //увеличиваем количество проголосовавших
                    $model->voters = $model->voters + 1;

                    $model->rating = $model->vote / $model->voters;
                    //округляем
                    //$model->rating = round($model->rating);



                    if ($model->save())
                    {
                        if(!Yii::app()->user->isGuest)
                        {
                            $ex_rate = CompaniesRating::model()->findByAttributes(array(
                            'user_id'=>  Yii::app()->user->id,
                            'company_id'=>Yii::app()->request->getPost('id'),
                            ));

                            if($ex_rate)
                            {
                                $ex_rate->value = $score;
                                $ex_rate->save();
                            }
                            else
                            {
                                $rate = new CompaniesRating();
                                $rate->user_id = Yii::app()->user->id;
                                $rate->company_id = $model->id;
                                $rate->value = $score;
                                $rate->save();
                            }
                        }  
                        
                        //если данные сохранились в бд, отдаем сообщение об успехе и устанавливем куку
                        $cookie = new CHttpCookie($cookie_name, $company_id);
                        $cookie->expire = $expires;
                        Yii::app()->request->cookies[$cookie_name] = $cookie;

                        //отдаем ответ браузеру пользователя в формате json
                        echo CJSON::encode(array(
                            'status' => 'OK',
                            'msg' => 'Спасибо. Ваш голос учтен.',
                            'voters'=>$model->voters,
                            'rating'=>  round($model->rating),
                        ));
                    }
                    else
                    {
                        //отдаем ответ браузеру пользователя в формате json
                        echo CJSON::encode(array(
                            'status' => 'ERR',
                            'msg' => 'Произошла ошибка при голосовании, попробуйте позже.',
                        ));
                    }
                }
            }
        }
        else
        {
            echo CJSON::encode(array(
                'status' => 'ERR',
                'msg' => 'У вас отключен javascript',
            ));
        }
    }

    public function actionCheckuser()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $email = CHtml::encode($_POST['email']);

            $user = User::model()->findByAttributes(array('email' => $email));

            if ($user)
            {
                $data['response'] = true;
            }
            else
            {
                $data['response'] = false;
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Companies();
        $gallery = new Gallery();
        $news = new NewsCompany();
        $user = new RegistrationForm('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        /**
         * Если отправляли форму
         */
        if (isset($_POST['Companies']))
        {
            //echo CVarDumper::dump(!empty($_POST['NewsCompany']['text']),10,true);exit;
            /**
             * Проверяем на наличие такого пользователя в системе
             */
            if (isset($_POST['RegistrationForm']['reg']))
            {
                $email = $_POST['RegistrationForm']['email'];
                /**
                 * если есть флаг регистрации, значит он равен нулю
                 */
                $author = User::model()->findByAttributes(array('email' => $email));
                $user_id = $author->id;
            }
            else
            {
                if (Yii::app()->user->isGuest)
                {
                    /**
                     * Если флага регистрации не пришло, значит это новый пользователь и 
                     * нужно его зарегистрировать
                     */
                    $profile = new Profile;

                    $user->attributes = $_POST['RegistrationForm'];
                    $user->username = $user->email;
                    $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
                    $profile->fio = $user->email;

                    $soucePassword = $user->password;
                    $user->activkey = UserModule::encrypting(microtime() . $user->password);
                    $user->password = UserModule::encrypting($user->password);
                    $user->verifyPassword = UserModule::encrypting($user->verifyPassword);
                    $user->superuser = 0;
                    $user->status = ((Yii::app()->getModule('user')->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);

                    if ($user->save())
                    {
                        $profile->user_id = $user->id;

                        $profile->save();
                        if (Yii::app()->getModule('user')->sendActivationMail)
                        {
                            $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $user->activkey, "email" => $user->email));
                            UserModule::sendMail($user->email, UserModule::t("You registered from {site_name}", array('{site_name}' => Yii::app()->name)), UserModule::t("Please activate you account go to <a href=\"{activation_url}\">{activation_url}</a>", array('{activation_url}' => $activation_url)));
                        }

                        if ((Yii::app()->getModule('user')->loginNotActiv || (Yii::app()->getModule('user')->activeAfterRegister && Yii::app()->getModule('user')->sendActivationMail == false)) && Yii::app()->getModule('user')->autoLogin)
                        {
                            $identity = new UserIdentity($user->username, $soucePassword);
                            $identity->authenticate();
                            Yii::app()->user->login($identity, 0);
                            //$this->redirect(Yii::app()->getModule('user')->returnUrl);
                        }
                        else
                        {
                            if (!Yii::app()->getModule('user')->activeAfterRegister && !Yii::app()->getModule('user')->sendActivationMail)
                            {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                            }
                            elseif (Yii::app()->getModule('user')->activeAfterRegister && Yii::app()->getModule('user')->sendActivationMail == false)
                            {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}' => CHtml::link(UserModule::t('Login'), Yii::app()->getModule('user')->loginUrl))));
                            }
                            elseif (Yii::app()->getModule('user')->loginNotActiv)
                            {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email or login."));
                            }
                            else
                            {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
                            }
                            //$this->refresh();
                            //$this->redirect(Yii::app()->homeUrl);
                            $user_id = $user->id;
                        }
                    }
                }
                else
                {
                    $user_id = Yii::app()->user->id;
                }
            }
            /**
             * Дальше сохраняем все остальные данные
             * 1. Сохраняем компанию
             * 2. Изображения
             * 3. Новости
             */
            $model->attributes = $_POST['Companies'];
            $model->address = str_replace(',',', ',$model->address);

            /**
             * Если есть загруженное лготип сохраняем его
             */
            $logo = CUploadedFile::getInstance($model, 'logo');
            if ($logo)
            {
                if ($logo->saveAs(Yii::getPathOfAlias('webroot') . '/content/companies/logo/' . $logo->name))
                {
                    //Если изображение сохранено в указанной директории
                    //Обрабатываем его, создаем эскизы(небольшие изображения)
                    //Создаем экземпляр класса Image(расширение) и передаем ему имя файла для обработки
                    $thumbs = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . '/content/companies/logo/' . $logo->name);
                    //Изменяем размер исходного изображения
                    $thumbs->resize(100, 100, 2);
                    //Сохраняем изображение с новым именем в новую директорию
                    $thumbs->save(Yii::getPathOfAlias('webroot') . '/content/companies/logo/' . $logo->name);

                            
                    $model->logo = $logo;
                }
            }

            $model->user_id = $user_id;
            $model->status = 0;

            if ($model->save())
            {
                // THIS is how you capture those uploaded images: remember that in your CMultiFile widget, you set 'name' => 'files'
                $images = CUploadedFile::getInstances($gallery, 'files');

                // proceed if the images have been set
                if (isset($images) && count($images) > 0)
                {

                    // go through each uploaded image
                    foreach ($images as $image => $pic)
                    {
                        if ($pic->saveAs(Yii::getPathOfAlias('webroot') . '/content/companies/' . $pic->name))
                        {
                            // add it to the main model now
                            $img_add = new Gallery();
                            $img_add->img = $pic->name;
                            $img_add->company_id = $model->id;

                            //Если изображение сохранено в указанной директории
                            //Обрабатываем его, создаем эскизы(небольшие изображения)
                            //Создаем экземпляр класса Image(расширение) и передаем ему имя файла для обработки
                            $thumbs = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . '/content/companies/' . $pic->name);
                            //Изменяем размер исходного изображения
                            $thumbs->resize(300, 250, 2);
                            //Сохраняем изображение с новым именем в новую директорию
                            $thumbs->save(Yii::getPathOfAlias('webroot') . '/content/companies/thumbs/tmb_' . $pic->name);

                            $img_add->thumb = 'tmb_' . $pic->name;
                            $img_add->save(); // DONE
                        }
                        else
                        {
                            echo 'Error';
                            exit;
                            // handle the errors here, if you want
                        }
                    }
                }
            }
            else
            {
                $errors['company'] = $model->getErrors();
            }
            /**
             * Если массив с новостями не пустой, сохраняем новости
             */
            if (!empty($_POST['NewsCompany']['text']))
            {
                foreach ($_POST['NewsCompany']['text'] as $k => $text)
                {
                    $news = new NewsCompany();
                    if (!empty($text))
                    {
                        $news->company_id = $model->id;
                        if (!empty($_POST['NewsCompany']['date'][$k]))
                        {
                            $news->date = strtotime($_POST['NewsCompany']['date'][$k]);
                        }
                        else
                        {
                            $news->date = time();
                        }
                        $news->text = $text;
                        if (!$news->save())
                        {
                            $errors['news'] = $news->getErrors();
                        }
                    }
                }
            }


            //echo CVarDumper::dump($_FILES,10,true);
            //echo CVarDumper::dump($_POST,10,true);exit;
//			$model->attributes=$_POST['Companies'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
            if (empty($errors))
            {
                Yii::app()->user->setFlash('message','Спасибо за информацию о компании. Она будет проверена и вскоре опубликована в нашем справочнике. После чего вы можете её редактировать и добавлять новую актуальную информацию.');
                $this->redirect('/companies');
            }
            else
            {
                Yii::app()->user->setFlash('message', 'Произошла ошибка при добавлении компании. Попробуйте позже.');
                //$data['message']= CVarDumper::dump($errors, 10, true);
                $this->redirect('/');
            }

            Yii::app()->end();
        }
        Yii::app()->clientScript->registerCssFile('/css/ui.css');
        $this->render('create', array(
            'model' => $model,
            'gallery' => $gallery,
            'news' => $news,
            'user' => $user,
                ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->clientScript->registerScriptFile('/js/jquery.equal-height-columns.js',  CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile('/js/jquery.pikachoose.min.js',  CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile('/js/jquery.fancybox-1.3.4.pack.js',  CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile('/css/base.css');
        Yii::app()->clientScript->registerCssFile('/css/news.css');
        Yii::app()->clientScript->registerCssFile('/css/jquery.fancybox-1.3.4.css');
        Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=AGLsdFEBAAAAC9QZNQIAeghrEX7jQPsHXcF5cNoaYEptcaIAAAAAAAAAAADcC_MkSuCqqL1mg95BzG34yrEo_w==', CClientScript::POS_HEAD);

        $model = Companies::model()->findByAttributes(array('user_id'=>Yii::app()->user->id, 'id'=>$id));


        if($model)
        {

            $gallery = Gallery::model()->findAllByAttributes(array('company_id'=>$id));
            if(!$gallery)
            {
                $gallery = new Gallery();
            }

            $news = NewsCompany::model()->findAllByAttributes(array('company_id'=>$id));
            if(!$news)
            {
                $news = new NewsCompany();
            }


            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            /*if (isset($_POST['Companies']))
            {
                $model->attributes = $_POST['Companies'];
                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->id));
            }*/

            $this->render('update', array(
                'model' => $model,
                'gallery' => $gallery,
                'news' => $news,
            ));
        }
        else
        {
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }
    }

    public function actionUpdateLogo()
    {
        $model = Companies::model()->findByAttributes(array('id'=>$_POST['Companies']['id'],'user_id'=>Yii::app()->user->id));

        if($model)
        {
            $old_logo = $model->logo;
            if(file_exists('/content/companies/logo'.$old_logo))
            {
                @unlink('/content/companies/logo'.$old_logo);
            }

            /**
             * Если есть загруженное лготип сохраняем его
             */
            $logo = CUploadedFile::getInstance($model, 'logo');
            if ($logo)
            {
                if ($logo->saveAs(Yii::getPathOfAlias('webroot') . '/content/companies/logo/' . $logo->name))
                {
                    //Если изображение сохранено в указанной директории
                    //Обрабатываем его, создаем эскизы(небольшие изображения)
                    //Создаем экземпляр класса Image(расширение) и передаем ему имя файла для обработки
                    $thumbs = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . '/content/companies/logo/' . $logo->name);
                    //Изменяем размер исходного изображения
                    $thumbs->resize(100, 100, 2);
                    //Сохраняем изображение с новым именем в новую директорию
                    $thumbs->save(Yii::getPathOfAlias('webroot') . '/content/companies/logo/' . $logo->name);


                    $model->logo = $logo->name;
                }
            }
            else
            {
                $model->logo = '';
            }

            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('logo'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            Yii::app()->user->setFlash('message','Не корректный запрос.');
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }

    }

    public function actionUpdateAddress()
    {
        $model = Companies::model()->findByAttributes(array('id'=>$_POST['Companies']['id'],'user_id'=>Yii::app()->user->id));

        if($model)
        {
            $model->address = CHtml::encode($_POST['Companies']['address']);
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('address'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            Yii::app()->user->setFlash('message','Не корректный запрос.');
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }
    }

    public function actionUpdatePhones()
    {
        $model = Companies::model()->findByAttributes(array('id'=>$_POST['Companies']['id'],'user_id'=>Yii::app()->user->id));

        if($model)
        {
            $model->phones = CHtml::encode($_POST['Companies']['phones']);
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('phones'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            Yii::app()->user->setFlash('message','Не корректный запрос.');
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }
    }

    public function actionUpdateSchedule()
    {
        $model = Companies::model()->findByAttributes(array('id'=>$_POST['Companies']['id'],'user_id'=>Yii::app()->user->id));

        if($model)
        {
            $model->schedule = CHtml::encode($_POST['Companies']['schedule']);
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('schedule'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            Yii::app()->user->setFlash('message','Не корректный запрос.');
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }
    }

    public function actionUpdateLink()
    {
        $model = Companies::model()->findByAttributes(array('id'=>$_POST['Companies']['id'],'user_id'=>Yii::app()->user->id));

        if($model)
        {
            $model->link = CHtml::encode($_POST['Companies']['link']);
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('link'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            Yii::app()->user->setFlash('message','Не корректный запрос.');
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }
    }

    public function actionUpdateVideo()
    {
        $model = Companies::model()->findByAttributes(array('id'=>$_POST['Companies']['id'],'user_id'=>Yii::app()->user->id));

        if($model)
        {
            $model->video = $_POST['Companies']['video'];
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('video'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            Yii::app()->user->setFlash('message','Не корректный запрос.');
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }
    }

    public function actionUpdateGallery()
    {
        //echo CVarDumper::dump($_POST,10,true);exit;
        if(!$_POST['Gallery']['id'])
        {
            $model = new Gallery();
        }
        else
        {
            $model = Gallery::model()->findByAttributes(array('id'=>$_POST['Gallery']['id']));
        }

        $pic = CUploadedFile::getInstance($model, 'files');

        if ($pic->saveAs(Yii::getPathOfAlias('webroot') . '/content/companies/' . $pic->name))
        {
            // add it to the main model now
            //$img_add = new Gallery();
            $model->img = $pic->name;
            $model->company_id = $_POST['Companies']['id'];

            //Если изображение сохранено в указанной директории
            //Обрабатываем его, создаем эскизы(небольшие изображения)
            //Создаем экземпляр класса Image(расширение) и передаем ему имя файла для обработки
            $thumbs = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . '/content/companies/' . $pic->name);
            //Изменяем размер исходного изображения
            $thumbs->resize(300, 250, 2);
            //Сохраняем изображение с новым именем в новую директорию
            $thumbs->save(Yii::getPathOfAlias('webroot') . '/content/companies/thumbs/tmb_' . $pic->name);

            $model->thumb = 'tmb_' . $pic->name;
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('img'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
    }

    public function actionUpdateDescription()
    {
        $model = Companies::model()->findByAttributes(array('id'=>$_POST['Companies']['id'],'user_id'=>Yii::app()->user->id));

        if($model)
        {
            $model->description = $_POST['Companies']['description'];
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('description'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            Yii::app()->user->setFlash('message','Не корректный запрос.');
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }
    }

    public function actionUpdateNews()
    {
        //echo CVarDumper::dump($_POST,10,true);exit;
        $model = NewsCompany::model()->findByAttributes(array('id'=>$_POST['NewsCompany']['id']));

        if($model)
        {
            if($_POST['NewsCompany']['date'])
            {
                $model->date = strtotime($_POST['NewsCompany']['date']);
            }
            $model->text = $_POST['NewsCompany']['text'];
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message',$model->getError('text'));
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            $model = new NewsCompany();
            $model->text = $_POST['NewsCompany']['text'];
            if($_POST['NewsCompany']['date'])
            {
                $model->date = $_POST['NewsCompany']['date'];
            }
            else
            {
                $model->date = time();
            }
            $model->company_id = $_POST['Companies']['id'];
            if($model->save())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                echo CVarDumper::dump($model->getErrors(),10,true);exit;
                //Yii::app()->user->setFlash('message',$model->getError('text'));
               // $this->redirect(Yii::app()->request->getUrlReferrer());
            }

        }
    }
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Companies');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Companies('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Companies']))
            $model->attributes = $_GET['Companies'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Companies the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Companies::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Companies $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'companies-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
