<?php

class RealtyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
                    'index',
                    'view',
                    'search',
                    'category',
                    'apartments',
                    'complain',
                    'preview',
                    'print',
                ),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','upload'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        Yii::app()->clientScript->registerCssFile('/css/board.css');

        Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=AGLsdFEBAAAAC9QZNQIAeghrEX7jQPsHXcF5cNoaYEptcaIAAAAAAAAAAADcC_MkSuCqqL1mg95BzG34yrEo_w==', CClientScript::POS_HEAD);

        $model = $this->loadModel($id);

        //Увеличиваем просморы
        $model->views += 1;
        $model->save();

        $this->render('view',array(
			'model'=>$model,
		));
	}

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionPrint($id)
    {
        $this->layout = '//layouts/board_print';

        Yii::app()->clientScript->registerCssFile('/css/board.css');

        Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=AGLsdFEBAAAAC9QZNQIAeghrEX7jQPsHXcF5cNoaYEptcaIAAAAAAAAAAADcC_MkSuCqqL1mg95BzG34yrEo_w==', CClientScript::POS_HEAD);

        $this->render('print',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionComplain()
    {
        $model=new Complain();
        $model->attributes=$_POST['Complain'];
        if($model->validate())
        {
            $headers="From: admin@supercennik.ru\r\nReply-To: admin@supercennik.ru";
            $body = "\n\nОтправитель: ".$model->name."\r\n Текст: ".$model->text."\r\n Прямая ссылка: ".$model->item;
            mail('foreach@mail.ru','Жалоба на объявление',$body,$headers);
        }
        $this->redirect(Yii::app()->request->getUrlReferrer());
    }

    public function actionPreview()
    {
        Yii::app()->clientScript->registerCssFile('/css/board.css');
        $this->render('preview');
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Realty;

        $category = RealtyCategory::model()->findAll();
        $city = Cities::model()->findAll();
        $types = RealtyTypes::model()->findAll();

        Yii::import( "xupload.models.XUploadForm" );
        $photos = new XUploadForm;


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Realty']))
        {
             //echo CVarDumper::dump($_POST,10,true);
            $model->attributes=$_POST['Realty'];
            $model->date_pub = time();
            $model->date_end = time()+60*60*24*25;
            $model->views = 0;
            //echo CVarDumper::dump($model->attributes,10,true);exit;
            if($model->save())
            {
                $this->redirect(array('view','id'=>$model->id));
            }

        }

        $this->render('create',array(
            'model'=>$model,
            'category'=>$category,
            'city'=>$city,
            'types'=>$types,
            'photos' => $photos,

        ));

	}

    /**
     * Загрузка файлов на сервер при добавлении недвижимости
     * @throws CHttpException
     */
    public function actionUpload()
    {
        Yii::import( "xupload.models.XUploadForm" );
        /**
         * Определить пути к папке для временного хранения файлов
         */
        //Локальный путь на сервере
        $path = realpath( Yii::app( )->getBasePath( )."/../content/board/uploads/tmp/" )."/";
        //Путь из веб
        $publicPath = Yii::app( )->getBaseUrl( )."/content/board/uploads/tmp/";

        //Это для IE который не обрабатывает 'Content-Type: приложения / JSON' правильно
        header( 'Vary: Accept' );
        if( isset( $_SERVER['HTTP_ACCEPT'] ) && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) )
        {
            header( 'Content-type: application/json' );
        }
        else
        {
            header( 'Content-type: text/plain' );
        }

        //Проверка что если удаляем загруженный файл
        if( isset( $_GET["_method"] ) )
        {
            if( $_GET["_method"] == "delete" )
            {
                if( $_GET["file"][0] !== '.' )
                {
                    $file = $path.$_GET["file"];
                    if( is_file( $file ) )
                    {
                        unlink( $file );
                    }
                }
                echo json_encode( true );
            }
        }
        else
        {
            $model = new XUploadForm;
            $model->file = CUploadedFile::getInstance( $model, 'file' );
            //проверяем, что файл был успешно загружен
            if( $model->file !== null )
            {
                //Получаем кой какие данные
                $model->mime_type = $model->file->getType( );
                $model->size = $model->file->getSize( );
                $model->name = $model->file->getName( );
                //(optional) генерируем случайное имя для файла
                $filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
                $filename .= ".".$model->file->getExtensionName( );
                if( $model->validate( ) )
                {
                    //Перемещаем файл во временную папку
                    $model->file->saveAs( $path.$filename );
                    chmod( $path.$filename, 0777 );

                    /**
                     * Генерируем превьюшку
                     */
                    //Если изображение сохранено в указанной директории
                    //Обрабатываем его, создаем эскизы(небольшие изображения)
                    //Создаем экземпляр класса Image(расширение) и передаем ему имя файла для обработки
                    $thumbs = Yii::app()->image->load($path.$filename);
                    //Изменяем размер исходного изображения
                    $thumbs->resize(150, 100, 2);
                    //Сохраняем изображение с новым именем в новую директорию
                    $thumbs->save($path.'thumbs/' . $filename);



                    //Теперь нам нужно сохранить этот путь к сессии пользователя
                    if( Yii::app( )->user->hasState( 'images' ) )
                    {
                        $userImages = Yii::app( )->user->getState( 'images' );
                    }
                    else
                    {
                        $userImages = array();
                    }
                    $userImages[] = array(
                        "path" => $path.$filename,
                        //сгенерированный эскиз
                        "thumb" => $path.'thumbs/'.$filename,
                        "filename" => $filename,
                        'size' => $model->size,
                        'mime' => $model->mime_type,
                        'name' => $model->name,
                    );
                    Yii::app( )->user->setState( 'images', $userImages );

                    //Now we need to tell our widget that the upload was succesfull
                    //We do so, using the json structure defined in
                    // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
                    echo json_encode( array( array(
                        "name" => $model->name,
                        //"type" => $model->mime_type,
                        //"size" => $model->size,
                        //"url" => $publicPath.$filename,
                        "thumbnail_url" => $publicPath."thumbs/$filename",
                        "delete_url" => $this->createUrl( "upload", array(
                            "_method" => "delete",
                            "file" => $filename
                        ) ),
                        "delete_type" => "POST"
                    ) ) );
                }
                else
                {
                    //If the upload failed for some reason we log some data and let the widget know
                    echo json_encode( array(
                        array( "error" => $model->getErrors( 'file' ),
                        ) ) );
                    Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
                        CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction"
                    );
                }
            }
            else
            {
                throw new CHttpException( 500, "Could not upload file" );
            }
        }
    }


    /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Realty']))
		{
			$model->attributes=$_POST['Realty'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

        Yii::app()->clientScript->registerCssFile('/css/board.css');

        $criteria = new CDbCriteria();

        $criteria->compare('status',1);
        $criteria->compare('checked',1);

        $sort = new CSort();
        $sort->attributes = array(
            'price'=>array(
                'asc'=>'price',
                'desc'=>'price desc',
            ),
            'date_pub'=>array(
                'asc'=>'date_pub',
                'desc'=>'date_pub desc',
            ),
        );

        /** После того, как будет загружена страница с виджетом,
         * сортировка будет происходить по этому параметру.
         * Если указан defaultOrder, то задается стиль для атрибута, по которому происходит сортировка.
         * В данном случае у created_at будет class="desc".
         */
        $sort->defaultOrder = array(
            'date_pub'=>CSort::SORT_DESC,
        );

        $dataProvider=new CActiveDataProvider('Realty', array(
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));

        $categories = RealtyCategory::model()->findAll();

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'categories'=>$categories,
        ));
	}

    public function actionCategory($id)
    {
        Yii::app()->clientScript->registerCssFile('/css/board.css');

        $criteria = new CDbCriteria();

        $criteria->compare('status',1);
        $criteria->compare('checked',1);
        $criteria->compare('category_id',$id);

        $sort = new CSort();
        $sort->attributes = array(
            'price'=>array(
                'asc'=>'price',
                'desc'=>'price desc',
            ),
            'date_pub'=>array(
                'asc'=>'date_pub',
                'desc'=>'date_pub desc',
            ),
        );

        /** После того, как будет загружена страница с виджетом,
         * сортировка будет происходить по этому параметру.
         * Если указан defaultOrder, то задается стиль для атрибута, по которому происходит сортировка.
         * В данном случае у created_at будет class="desc".
         */
        $sort->defaultOrder = array(
            'date_pub'=>CSort::SORT_DESC,
        );

        $dataProvider=new CActiveDataProvider('Realty', array(
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));

        $categories = RealtyCategory::model()->findAll();

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'categories'=>$categories,
        ));
    }

    /**
     * Выдача объявлений по фильтру
     */
    public function actionSearch()
    {
        Yii::app()->clientScript->registerCssFile('/css/board.css');


        $criteria = new CDbCriteria();

        if($_POST)
        {
            Yii::app()->session['realty_search'] = $_POST;
        }

        /**
         * Берем параметры из пост запроса
         */

        if($_POST['query'])
        {
            //строка запроса
            $query = CHtml::encode($_POST['query']);
            $criteria->addSearchCondition('title',$query, true, 'OR');
            $criteria->addSearchCondition('details',$query, true, 'OR');
        }
        if($_POST['type'])
        {
            $type = CHtml::encode($_POST['type']);
            $criteria->compare('type_id',$type);
        }
        if($_POST['category'])
        {
            $cat_id = CHtml::encode($_POST['category']);
            $criteria->compare('category_id',$cat_id);
        }
        if($_POST['city'])
        {
            $city = CHtml::encode($_POST['city']);

            $criteria->compare('city_id',$city);
        }
        if($_POST['minprice'] || $_POST['maxprice'])
        {
            $min = CHtml::encode($_POST['minprice']);
            $max = CHtml::encode($_POST['maxprice']);

            $criteria->addBetweenCondition('price',($min)?$min:0, ($max)?$max:9000000000);
        }
        if(isset($_POST['notprice']))
        {
            $notprice = CHtml::encode($_POST['notprice']);
            $criteria->compare('price','>0');
        }


        $criteria->compare('status',1);
        $criteria->compare('checked',1);
        //$criteria->order = 'date_pub';

        $sort = new CSort();
        $sort->attributes = array(
            'price'=>array(
                'asc'=>'price',
                'desc'=>'price desc',
            ),
            'date_pub'=>array(
                'asc'=>'date_pub',
                'desc'=>'date_pub desc',
            ),
        );

        /** После того, как будет загружена страница с виджетом,
         * сортировка будет происходить по этому параметру.
         * Если указан defaultOrder, то задается стиль для атрибута, по которому происходит сортировка.
         * В данном случае у created_at будет class="desc".
         */
        $sort->defaultOrder = array(
            'date_pub'=>CSort::SORT_DESC,
        );

        $dataProvider=new CActiveDataProvider('Realty', array(
            'criteria'=>$criteria,
            'sort'=>$sort,
        ));

        $categories = RealtyCategory::model()->findAll();

        $this->render('search',array(
            'dataProvider'=>$dataProvider,
            'categories'=>$categories,
            'city'=>(isset($city)?$city:''),
        ));
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Realty('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Realty']))
			$model->attributes=$_GET['Realty'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionApartments()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $cat = CHtml::encode($_POST['cat']);

            $result = RealtyCategory::model()->findByPk($cat);

            echo $result->apartments; exit;
        }
        else
        {
            return false;
        }
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Realty the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Realty::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Realty $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='realty-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
