<?php

class CategoriesCompanyController extends Controller
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
				'actions'=>array('create','update','admin','delete','setName','groupDelete'),
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
	public function actionCreateRoot()
	{
        if(!$_POST)
        {
            $referer = Yii::app()->request->getUrlReferrer();
            Yii::app()->user->setFlash('referer',$referer);
        }

		$model = new CategoriesCompany;
                
                //$roots = CategoriesCompany::model()->findAllByAttributes(array('parent_id'=>NULL));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CategoriesCompany']))
		{
            Yii::app()->user->setFlash('referer',Yii::app()->user->getFlash('referer'));

			$model->attributes = $_POST['CategoriesCompany'];
                        
			if($model->save())
            {
                  //$this->redirect(array('admin'));
                $this->redirect(Yii::app()->user->getFlash('referer'));
            }
				
		}

		$this->render('createRoot',array(
                    'model'=>$model,
                    //'roots'=>$roots,
		));
	}

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateChild()
    {
        if(!$_POST)
        {
            $referer = Yii::app()->request->getUrlReferrer();
            Yii::app()->user->setFlash('referer',$referer);
        }

        $model = new CategoriesCompany;

        $roots = CategoriesCompany::model()->findAllByAttributes(array('parent_id'=>NULL));

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['CategoriesCompany']))
        {
            Yii::app()->user->setFlash('referer',Yii::app()->user->getFlash('referer'));

            $model->attributes = $_POST['CategoriesCompany'];

            //echo CVarDumper::dump($model->attributes,10,true);exit;

            if($model->save())
            {
                //$this->redirect(array('admin'));
                $this->redirect(Yii::app()->user->getFlash('referer'));
            }

        }

        $this->render('create',array(
            'model'=>$model,
            'roots'=>$roots,
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
                
        $roots = CategoriesCompany::model()->findAllByAttributes(array('parent_id'=>NULL));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CategoriesCompany']))
		{
            //Yii::app()->user->setFlash('referer',Yii::app()->user->getFlash('referer'));

			$model->attributes=$_POST['CategoriesCompany'];

			if($model->save())
            {
                  //$this->redirect(array('admin'));
                $this->redirect($this->createUrl('admin',array('id_page'=>Yii::app()->request->getQuery("returnPage", 1))));
                  //$this->redirect($referer);
            }
				
		}


		$this->render('update',array(
                    'model'=>$model,
                    'roots'=>$roots,
		));
	}

    /**
     * Быстрое редактирование названия категории компании
     * @return bool
     */
    public function actionSetName()
    {
        if (!Yii::app()->request->isAjaxRequest)
        {
            return false;
        }
        $id = $_POST['item'];
        $value = $_POST['value'];
        $model = $this->loadModel($id);
        $model->name = $value;
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
                $model= CategoriesCompany::model();
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CategoriesCompany');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CategoriesCompany('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CategoriesCompany']))
                {
                    $model->attributes=$_GET['CategoriesCompany'];
                }
			               
                // получаем дерево экземпляров:
                $tree = CategoriesCompany::model()->getAllCategoriesForGrid();
                
                $arrayDataProvider=new CArrayDataProvider($tree, array(
                    'id'=>'id',
                ));
                
                
                // кол-во корневых элементов:
                //$count = $tree->getChildCount();
                
                //echo CVarDumper::dump($tree,10,true);
                //echo CVarDumper::dump($count,10,true);

		$this->render('admin',array(
			'model'=>$model,
                        'tree'=>$arrayDataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CategoriesCompany the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CategoriesCompany::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CategoriesCompany $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='categories-company-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
