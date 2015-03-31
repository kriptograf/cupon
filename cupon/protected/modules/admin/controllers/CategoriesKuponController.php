<?php

class CategoriesKuponController extends Controller
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
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete','toggle','groupDelete'),
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

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}*/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CategoriesKupon;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CategoriesKupon']))
		{
			$model->attributes=$_POST['CategoriesKupon'];
			if($model->save())
				$this->redirect(array('admin'));
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

		if(isset($_POST['CategoriesKupon']))
		{
			$model->attributes=$_POST['CategoriesKupon'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionSetName()
    {
        if(!Yii::app()->request->isAjaxRequest)
        {
             return false;
        }
        $id = $_POST['item'];
        $value = $_POST['value'];
        $model = CategoriesKupon::model()->findByPk($id);
        $model->name = $value;
        if($model->save())
        {
            $arr['msg']='ok';
            $arr['close']= $_POST['close'];
            $arr['open']= $_POST['open'];
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
                $model= CategoriesKupon::model();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('id', $items);
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

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CategoriesKupon');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new CategoriesKupon('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CategoriesKupon']))
			$model->attributes=$_GET['CategoriesKupon'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CategoriesKupon the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CategoriesKupon::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CategoriesKupon $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='categories-kupon-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
