<?php

class MyAdsController extends Controller
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array(
                    'index',
                    'view',
                    'edit',
                    'delete',
                    'prolong',
                    'preview',
                    'delImg',
                    'delRealtyImg',
                    'bulkDelete',
                    'bulkExt',
                ),
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

	public function actionIndex()
	{
        Yii::app()->clientScript->registerCssFile('/css/board.css');

        $criteria = new CDbCriteria();

        $criteria->compare('user_id',Yii::app()->user->id);


        //$sort = new CSort();
        /*$sort->attributes = array(
            'status'=>array(
                'asc'=>'status',
                'desc'=>'status desc',
            ),
            'status'=>array(
                'asc'=>'status desc',
                'desc'=>'status',
            ),
        );*/

        /** После того, как будет загружена страница с виджетом,
         * сортировка будет происходить по этому параметру.
         * Если указан defaultOrder, то задается стиль для атрибута, по которому происходит сортировка.
         * В данном случае у created_at будет class="desc".
         */
        /*$sort->defaultOrder = array(
            'date_pub'=>CSort::SORT_DESC,
        );*/

        $dataProvider=new CActiveDataProvider('Ads', array(
            'criteria'=>$criteria,
            //'sort'=>$sort,
        ));

        $realty=new CActiveDataProvider('Realty', array(
            'criteria'=>$criteria,
            //'sort'=>$sort,
        ));

        $categories = BoardCategory::model()->findAll();

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'realty'=>$realty,
            'categories'=>$categories,
        ));
	}

	public function actionView($id)
	{
        $section = Yii::app()->request->getParam('section');
        Yii::app()->clientScript->registerCssFile('/css/board.css');

        Yii::app()->clientScript->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=AGLsdFEBAAAAC9QZNQIAeghrEX7jQPsHXcF5cNoaYEptcaIAAAAAAAAAAADcC_MkSuCqqL1mg95BzG34yrEo_w==', CClientScript::POS_HEAD);



        if($section && $section==='realty')
        {
            $model = Realty::model()->findByPk($id);
            $this->render('viewRealty',array(
                'model'=>$model,
            ));
        }
        elseif($section && $section==='auto')
        {
            $model = Auto::model()->findByPk($id);
            $this->render('viewAuto',array(
                'model'=>$model,
            ));
        }
        else
        {
            $model = $this->loadModel($id);
            $this->render('view',array(
                'model'=>$model,
            ));
        }

	}

    /**
     * Продление публикации объявления
     * @param $id
     */
    public function actionProlong($id)
    {
        $section = Yii::app()->request->getParam('section');

        if(Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->homeUrl);
        }
        $criteria = new CDbCriteria();
        $criteria->compare('id',$id);
        $criteria->compare('user_id',Yii::app()->user->id);

        if($section && $section==='realty')
        {
            $model = Realty::model()->find($criteria);

            if($model)
            {
                $model->date_pub = time();
                $model->date_end = time()+60*60*24*25;
                $model->status = 1;

                if($model->save())
                {
                    $this->redirect(Yii::app()->request->getUrlReferrer());
                }
                else
                {
                    echo CVarDumper::dump($model->getErrors(),10,true);
                }

            }
        }
        else
        {
            $model = Ads::model()->find($criteria);

            if($model)
            {
                $model->date_pub = time();
                $model->date_end = time()+60*60*24*25;
                $model->status = 1;

                if($model->save())
                {
                    $this->redirect(Yii::app()->request->getUrlReferrer());
                }

            }
        }

    }

    public function actionEdit($id)
    {
        $section = Yii::app()->request->getParam('section');

        if(Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->homeUrl);
        }

        $criteria = new CDbCriteria();
        $criteria->compare('id',$id);
        $criteria->compare('user_id',Yii::app()->user->id);

        if($section && $section==='realty')
        {
            $model = Realty::model()->find($criteria);

            $category = RealtyCategory::model()->findAll();
            $city = Cities::model()->findAll();
            $types = RealtyTypes::model()->findAll();

            $images = RealtyImg::model()->findAll('ads_id='.$model->id);

            Yii::import( "xupload.models.XUploadForm" );
            $photos = new XUploadForm;


            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Realty']))
            {
                // echo CVarDumper::dump($_POST,10,true);
                // echo CVarDumper::dump($_FILES,10,true);exit;
                $model->attributes=$_POST['Realty'];
                //$model->date_pub = time();
                //$model->date_end = time()+60*60*24*25;
                $model->status = 0;
                if($model->save())
                {
                    $model->addImages();
                    $this->redirect(array('view','id'=>$model->id,'section'=>'realty'));
                }

            }

            $this->render('editRealty',array(
                'model'=>$model,
                'category'=>$category,
                'city'=>$city,
                'types'=>$types,
                'photos' => $photos,
                'images'=>$images,

            ));
        }
        else
        {
            $model = Ads::model()->find($criteria);

            $category = BoardCategory::model()->findAll();
            $city = Cities::model()->findAll();
            $types = Types::model()->findAll();

            $images = AdsImg::model()->findAll('ads_id='.$model->id);

            Yii::import( "xupload.models.XUploadForm" );
            $photos = new XUploadForm;


            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Ads']))
            {
                // echo CVarDumper::dump($_POST,10,true);
                // echo CVarDumper::dump($_FILES,10,true);exit;
                $model->attributes=$_POST['Ads'];
                //$model->date_pub = time();
                //$model->date_end = time()+60*60*24*25;
                $model->status = 0;
                if($model->save())
                {
                    $model->addImages();
                    $this->redirect(array('view','id'=>$model->id));
                }

            }

            $this->render('edit',array(
                'model'=>$model,
                'category'=>$category,
                'city'=>$city,
                'types'=>$types,
                'photos' => $photos,
                'images'=>$images,

            ));
        }

    }

    public function actionBulkDelete()
    {
        echo CVarDumper::dump($_POST,10,true);exit;
    }

    public function actionBulkExt()
    {
        echo CVarDumper::dump($_POST,10,true);exit;
    }

    public function actionDelImg($id)
    {
        $img = AdsImg::model()->findByPk($id);
        if($img->delete())
        {
            if( is_file($img->img))
            {
                unlink($img->img);
            }
            if( is_file($img->thumb))
            {
                unlink($img->thumb);
            }
            echo json_encode( true );
        }
    }

    public function actionDelRealtyImg($id)
    {
        $img = RealtyImg::model()->findByPk($id);
        if($img->delete())
        {
            if( is_file($img->img))
            {
                unlink($img->img);
            }
            if( is_file($img->thumb))
            {
                unlink($img->thumb);
            }
            echo json_encode( true );
        }
    }

    public function actionDelete($id)
    {
        $section = Yii::app()->request->getParam('section');

        if(Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->homeUrl);
        }
        $criteria = new CDbCriteria();
        $criteria->compare('id',$id);
        $criteria->compare('user_id',Yii::app()->user->id);

        if($section && $section==='realty')
        {
            $model = Realty::model()->find($criteria);

            if($model->delete())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message','Невозможно удалить объявление');
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }
        else
        {
            $model = Ads::model()->find($criteria);

            if($model->delete())
            {
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
            else
            {
                Yii::app()->user->setFlash('message','Невозможно удалить объявление');
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }


    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Ads the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Ads::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}