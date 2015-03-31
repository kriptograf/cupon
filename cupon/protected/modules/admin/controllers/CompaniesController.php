<?php

class CompaniesController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/admincolumn2';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'setTitle', 'setAddr', 'actionDelItemGallery'),
                'users' => array('admin'),
            ),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Companies;
        $gallery = new Gallery();
        $news = new NewsCompany();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Companies']))
        {
            $model->attributes = $_POST['Companies'];

            /**
             * Если есть загруженное изображение изменяем его
             */
            $logo = CUploadedFile::getInstance($model, 'logo');
            if ($logo)
            {
                if ($logo->saveAs(Yii::getPathOfAlias('webroot') . '/content/companies/logo/' . $logo->name))
                {
                    $model->logo = $logo;
                }
            }


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
                            $thumbs->resize(300, 250);
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

                $this->redirect(array('admin'));
                //$this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }

        $this->render('create', array(
            'model' => $model,
            'gallery' => $gallery,
            'news'=>$news,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {


        $model = $this->loadModel($id);

        $gallery = new Gallery();

        $news = new NewsCompany();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Companies']))
        {

            $model->attributes = $_POST['Companies'];
            //echo CVarDumper::dump($model->attributes,10,true);exit;
            /**
             * Если есть загруженное изображение изменяем его
             */
            $logo = CUploadedFile::getInstance($model, 'logo');
            if ($logo)
            {
                if ($logo->saveAs(Yii::getPathOfAlias('webroot') . '/content/companies/logo/' . $logo->name))
                {
                    $model->logo = $logo;
                }
            }


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

                /**
                 * Если массив с новостями не пустой, сохраняем новости
                 */
                if (!empty($_POST['NewsCompany']['text']))
                {
                    //foreach ($_POST['NewsCompany']['text'] as $k => $text)
                    foreach ($model->newsCompany as $k => $news)
                    {

                        //$news = new NewsCompany();
                        if (!empty($_POST['NewsCompany']['text'][$k]))
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
                            $news->text = $_POST['NewsCompany']['text'][$k];
                            if (!$news->save())
                            {
                                $errors['news'] = $news->getErrors();

                            }
                        }
                    }

                }

                $this->redirect($this->createUrl('admin',array('Companies_page'=>Yii::app()->request->getQuery("returnPage", 1))));
                //$this->redirect(Yii::app()->user->getFlash('referer'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'gallery' => $gallery,
            'news' => $news,
        ));
    }

    /**
     * Быстрое редактирование названия компании
     * @return bool
     */
    public function actionSetTitle()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            return false;
        }
        $id = $_POST['item'];
        $value = $_POST['value'];
        $model = $this->loadModel($id);
        $model->title = $value;
        if ($model->save())
        {
            $arr['msg'] = 'ok';
            $arr['close'] = $_POST['close'];
            $arr['open'] = $_POST['open'];
            echo json_encode($arr);
        }
    }

    /**
     * Быстрое редактирование описания компании
     * @return bool
     */
    public function actionSetDesc()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            return false;
        }
        $id = $_POST['item'];
        $value = $_POST['value'];
        $model = $this->loadModel($id);
        $model->description = $value;
        if ($model->save())
        {
            $arr['msg'] = 'ok';
            $arr['close'] = $_POST['close'];
            $arr['open'] = $_POST['open'];
            echo json_encode($arr);
        }
    }

    /**
     * Быстрое редактирование адреса компании
     * @return bool
     */
    public function actionSetAddr()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            return false;
        }
        $id = $_POST['item'];
        $value = $_POST['value'];
        $model = $this->loadModel($id);
        $model->address = $value;
        if ($model->save())
        {
            $arr['msg'] = 'ok';
            $arr['close'] = $_POST['close'];
            $arr['open'] = $_POST['open'];
            echo json_encode($arr);
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
     * Массовое удаление записей
     * @throws CHttpException
     */
    public function actionGroupDelete()
    {
        if (isset($_POST))
        {
            $items = $_POST['group-checkbox-column'];
            if ($items)
            {
                $model = Companies::model();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('id', $items);
                if ($model->deleteAll($criteria))
                {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
                else
                {
                    throw new CHttpException(400, 'Invalid request. DataBase error.');
                }
            }
            else
            {
                throw new CHttpException(400, 'Вы не выбрали записи для удаления.');
            }
        }
        else
        {
            throw new CHttpException(400, 'Вы пытаетесь обмануть судьбу!');
        }
    }

    public function actionDelItemGallery()
    {
        $id = $_POST['id'];
        $model = Gallery::model()->findByPk($id);
        if ($model->delete())
        {
            echo json_encode(array('msg' => $id));
        }
        Yii::app()->end();
    }

    /**
     * Переключатель статуса ajax
     * @param $id
     * @param $attribute
     * @throws CHttpException
     */
    public function actionToggle($id, $attribute)
    {
        if (!in_array($attribute, array('status')))
            throw new CHttpException(400, 'Некорректный запрос');

        $model = $this->loadModel($id);
        $model->$attribute = $model->$attribute ? 0 : 1;
        if (!$model->save())
        {
            echo CVarDumper::dump($model->getErrors(), 10, true);
            exit;
        }
        else
        {
            echo Companies::getCountNew();
            exit;
        }

        if (!Yii::app()->request->isAjaxRequest)
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
     * Manages all models.
     */
    public function actionNewCompany()
    {
        $model = new Companies('searchnew');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Companies']))
            $model->attributes = $_GET['Companies'];

        $this->render('newcompany', array(
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
