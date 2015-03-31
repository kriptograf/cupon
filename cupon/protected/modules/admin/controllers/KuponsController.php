<?php

class KuponsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admincolumn2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete','toggle','groupDelete','setAction','setCode'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Kupons;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Kupons']))
		{
            /*
             * Удаляем кеш для рандомной выборки купонов
             */
            Yii::app()->cache->delete('rand_kupons');

			$model->attributes=$_POST['Kupons'];

            $image = CUploadedFile::getInstance($model,'image');
            if($image)
            {
                if($image->saveAs(Yii::getPathOfAlias('webroot').'/content/kupones/'.$image->name))
                {
                    /**
                     * Если изображение сохранено успешно, делаем из него эскиз
                     * Используем расширение IMAGE из директории extensions
                     */
                    $thumbs = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . '/content/kupones/' . $image->name);
                    //Изменяем размер исходного изображения
                    $thumbs->resize(250, 160, 2);
                    //Сохраняем эскиз с новым именем в новую директорию
                    $thumbs->save(Yii::getPathOfAlias('webroot') . '/content/kupones/thumbs/' . $image->name);

                    $model->image = $image->name;
                }
            }


            if($model->old_price && $model->new_price)
            {
                $tax = $model->old_price-$model->new_price;
                $tax = $tax/$model->old_price*100;
                $model->tax = (int)$tax;
            }


            $model->start_date = date('Y-m-d H:i', strtotime($model->start_date));

            $model->end_date = date('Y-m-d H:i', strtotime($model->end_date));
            /**
             * вычисляем разницу новой и старой цены
             */
            $model->diff = $model->old_price - $model->new_price;


			if($model->save())
            {
                $this->redirect(array('admin'));
            }

		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Kupons']))
		{
			$model->attributes=$_POST['Kupons'];

            if(!empty($_FILES['Kupons']['tmp_name']['image']))
            {
                /**
                 * Если есть новый файл для загрузки , удаляем старый из папки
                 */
                @unlink(Yii::getPathOfAlias('webroot').'/content/kupones/'.$model->image);
                $image = CUploadedFile::getInstance($model,'image');
                if($image->saveAs(Yii::getPathOfAlias('webroot').'/content/kupones/'.$image->name))
                {
                    $thumbs = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . '/content/kupones/' . $image->name);
                    //Изменяем размер исходного изображения
                    $thumbs->resize(250, 160);
                    //Сохраняем изображение с новым именем в новую директорию
                    $thumbs->save(Yii::getPathOfAlias('webroot') . '/content/kupones/thumbs/' . $image->name);

                    $model->image = $image->name;
                }
            }

            $tax = $model->old_price-$model->new_price;
            $tax = $tax/$model->old_price*100;
            $model->tax = (int)$tax;

            $model->start_date = date('Y-m-d H:i', strtotime($model->start_date));

            $model->end_date = date('Y-m-d H:i', strtotime($model->end_date));

            /**
             * вычисляем разницу новой и старой цены
             */
            $model->diff = $model->old_price - $model->new_price;

			if($model->save())
            {
                $this->redirect(array('admin'));
            }

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    /**
     * Быстрое редактирование названия акции
     * @return bool
     */
    public function actionSetAction()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            return false;
        }
        $id = $_POST['item'];
        $value = $_POST['value'];
        $model = $this->loadModel($id);
        $model->action = $value;
        if ($model->save())
        {
            $arr['msg'] = 'ok';
            $arr['close'] = $_POST['close'];
            $arr['open'] = $_POST['open'];
            echo json_encode($arr);
        }
    }

    /**
     * Быстрое редактирование названия акции
     * @return bool
     */
    public function actionSetCode()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            return false;
        }
        $id = $_POST['item'];
        $value = $_POST['value'];
        $model = $this->loadModel($id);
        $model->code = $value;
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

    /**
     * Массовое удаление записей
     * @throws CHttpException
     */
    public function actionGroupDelete()
    {
        if(isset($_POST))
        {
            $items = $_POST['group-checkbox-column'];
            if($items)
            {
                $model= Kupons::model();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('id_kupon', $items);
                if($model->deleteAll($criteria))
                {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
                else
                {
                    throw new CHttpException(400,'Invalid request. DataBase error.');
                }
            }
            else
            {
                throw new CHttpException(400,'Вы не выбрали записи для удаления.');
            }
        }
        else
        {
            throw new CHttpException(400,'Вы пытаетесь обмануть судьбу!');
        }

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
        if(!$model->save())
        {
            echo CVarDumper::dump($model->getErrors(),10,true);exit;
        }

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Kupons');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Kupons('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Kupons']))
			$model->attributes=$_GET['Kupons'];

		$this->render('admin',array(
			'model'=>$model,
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
		$model=Kupons::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Kupons $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='kupons-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
