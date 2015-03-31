<?php

class CommentsController extends Controller
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','create','update','admin','delete','toggle'),
				'users'=>UserModule::getAdmins(),
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
		$model=new Comments;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comments']))
		{
			$model->attributes=$_POST['Comments'];

            $model->date = date('Y-m-d', time());

			if($model->save())
            {
                if(Yii::app()->request->isAjaxRequest)
                {
                    $comment = $this->renderPartial('_view',array('data'=>Comments::model()->findByPk($model->id)),true, false);
                    echo json_encode(array('result'=>'success' ,'comment'=>$comment));
                    Yii::app()->end();
                }
                else
                {
                    $this->redirect(array('admin'));
                }

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

		if(isset($_POST['Comments']))
		{
			$model->attributes=$_POST['Comments'];
			if($model->save())
				$this->redirect(array('admin'));
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
        $id = Yii::app()->request->getParam('id');

        $creiteria = new CDbCriteria();
        $creiteria->compare('kupon_id',$id);
        $creiteria->compare('user_id',Yii::app()->user->id);
        $user = Comments::model()->find($creiteria);
        if($user)
        {
            $flag = 0;
        }
        else
        {
            $flag = 1;
        }

        $model = new Comments();

		$dataProvider=new CActiveDataProvider('Comments', array(
            'criteria'=>array(
                'condition'=>'kupon_id='.$id,
                'order'=>'date,id DESC',
            ),
        ));
		$comments = $this->renderPartial('index',array(
			'dataProvider'=>$dataProvider,
            'model'=>$model,
		),true,false);

        $output = array(
            'flag'=>$flag,
            'comments'=>$comments,
        );
        echo json_encode($output);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Comments('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comments']))
			$model->attributes=$_GET['Comments'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Comments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Comments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Comments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
