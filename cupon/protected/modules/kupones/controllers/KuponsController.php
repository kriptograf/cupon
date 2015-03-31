<?php

class KuponsController extends Controller
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
                'actions' => array('index', 'view', 'category'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'rate', 'print','activate'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
        Yii::app()->clientScript->registerScriptFile('/js/jquery.equal-height-columns.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=AGLsdFEBAAAAC9QZNQIAeghrEX7jQPsHXcF5cNoaYEptcaIAAAAAAAAAAADcC_MkSuCqqL1mg95BzG34yrEo_w==', CClientScript::POS_HEAD);
        //Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/countdown.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/print.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/comments.css');
        Yii::app()->clientScript->registerScriptFile('/js/jquery.pikachoose.min.js',  CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile('/js/jquery.fancybox-1.3.4.pack.js',  CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile('/css/base.css');
        Yii::app()->clientScript->registerCssFile('/css/jquery.fancybox-1.3.4.css');


        $catKupones = CategoriesKupon::model()->findAll('1 ORDER BY name');

        $model = $this->loadModel($id);

        /**
         * Увеличиваем количество просмотров
         * Ставим куку на 12 часов, что пользователь уже просматривал эту компанию
         */
        $cookie = Yii::app()->request->cookies['view_kupon'.$id]->value;
        if(!isset($cookie) && $cookie!=1)
        {
            $cookie = new CHttpCookie('view_kupon'.$id, 1);
            $cookie->expire = time()+60*60*12;
            Yii::app()->request->cookies['view_kupon'.$id] = $cookie;
            $model->views = $model->views+1;
            if(!$model->save())
            {
                echo CVarDumper::dump($model->getErrors(),10,true);
            }
        }

        $gallery = Gallery::model()->findAll('company_id = ' . $model->company->id);

        $comments = new Comments();

        $this->render('view', array(
            'model' => $model,
            'catKupones' => $catKupones,
            'gallery' => $gallery,
            'comments' => $comments,
        ));
    }
    
    public function actionActivate()
    {
        $id = $_POST['id'];
        $activ = new KuponsActive();
        $activ->user_id = Yii::app()->user->id;
        $activ->kupon_id = $id;
        $activ->date = time();
        if($activ->save())
        {
            $userkupon = new UsersKupons();
            $userkupon->user_id = Yii::app()->user->id;
            $userkupon->kupon_id = $id;
            $userkupon->save();
        }
    }

    public function actionPrint($id)
    {
        $this->layout = '//layouts/print';
        //Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU', CClientScript::POS_HEAD);
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/countdown.js', CClientScript::POS_END);
        //Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/comments.css');


        $model = $this->loadModel($id);

        /*$pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf',
            'P', 'cm', 'A4', true, 'UTF-8');
        //$pdf->SetCreator(PDF_CREATOR);
        //$pdf->SetAuthor("Nicola Asuni");
        $pdf->SetTitle($model->action);
        //$pdf->SetSubject("TCPDF Tutorial");
        //$pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //$pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "BI", 20);
        $pdf->Cell(0,10,"Example 002",1,1,'C');
        $pdf->writeHTML($model, true, false, false, false, '');
        $pdf->Output("example_002.pdf", "I");*/

        $this->render('_print', array(
            'model' => $model,
        ));
    }

    public function actionCategory()
    {
        $id_category = Yii::app()->request->getParam('id', 1);

        $catKupones = CategoriesKupon::model()->findAll('1 ORDER BY name');

        //количество записей на странице
        $pageSize = '15';
        $cookie = Yii::app()->request->cookies['page_kupones']->value;
        if($cookie)
        {
            $pageSize = $cookie;
        }

//        $criteria = new CDbCriteria();
//        $criteria->compare('cat_id',$id_category);
//
//        $kupones = Kupons::model()->findAll($criteria);
//
//        $this->render('category', array(
//            'catKupones'=>$catKupones,
//            'model'=>$kupones,
//        ));

        $criteria = new CDbCriteria();
        $criteria->compare('t.city_id', Yii::app()->user->getState('currentCity',1));
        $criteria->compare('cat_id', $id_category);
        $criteria->compare('t.status',1);
        $criteria->with=array('company'=>array('company.checked'=>1));
        $criteria->compare('company.checked',1);


        $total = Kupons::model()->count($criteria);

        $pages = new CPagination($total);
        $pages->pageSize = $pageSize;
        $pages->applyLimit($criteria);

        $this->render('category', array(
            'catKupones' => $catKupones,
            'dataProvider' => new CActiveDataProvider('Kupons', array(
                'criteria' => array(
                    'with'   => array('company'=>array('company.checked'=>1)),
                    'condition' => 't.city_id='.Yii::app()->user->getState('currentCity',1).' AND cat_id =' . $id_category.' AND company.checked=1 AND t.status=1',
                ),
                'pagination' => array(
                    'pageSize' => $pageSize,
                ),
                    )),
        ));
    }

    public function actionRate()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
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
                $kupon_id = Yii::app()->request->getPost('id');

                //задаем имя куки
                $cookie_name = 'kupon_' . $kupon_id;

                //проверяем есть ли значение в куке, если есть отдаем код ошибки и сообощение
                if (Yii::app()->request->cookies[$cookie_name]->value)
                {
                    //отдаем ответ браузеру пользователя в формате json
                    echo CJSON::encode(array(
                        'status' => 'ERR',
                        'msg' => 'Вы уже голосовали за этот купон',
                    ));
                }
                else
                {
                    //echo CVarDumper::dump('нет куки', 10, true);exit;
                    //Если кука не записана обрабатываем запрос
                    $model = Kupons::model()->findByPk($kupon_id);

                    $this->performAjaxValidation($model);

                    //берем значение голосования из массива пост
                    $score = Yii::app()->request->getPost('rate');

                    //вычисляем рейтинг купона
                    $model->vote += $score;

                    //увеличиваем количество проголосовавших
                    $model->voters = $model->voters + 1;

                    $model->rating = $model->vote / $model->voters;
                    //округляем
                    //$model->rating = round($model->rating);



                    if ($model->save())
                    {
                        //если данные сохранились в бд, отдаем сообщение об успехе и устанавливем куку
                        $cookie = new CHttpCookie($cookie_name, $kupon_id);
                        $cookie->expire = $expires;
                        Yii::app()->request->cookies[$cookie_name] = $cookie;

                        //отдаем ответ браузеру пользователя в формате json
                        echo CJSON::encode(array(
                            'status' => 'OK',
                            'msg' => 'Спасибо. Ваш голос учтен.',
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Kupons;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Kupons']))
        {
            $model->attributes = $_POST['Kupons'];


            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_kupon));
        }

        $this->render('create', array(
            'model' => $model,
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Kupons']))
        {
            $model->attributes = $_POST['Kupons'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_kupon));
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
        $dataProvider = new CActiveDataProvider('Kupons');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Kupons('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Kupons']))
            $model->attributes = $_GET['Kupons'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Kupons the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Kupons::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Kupons $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'kupons-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
