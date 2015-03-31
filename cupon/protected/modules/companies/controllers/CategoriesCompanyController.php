<?php

class CategoriesCompanyController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete'),
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
        //$categories = CategoriesCompany::model()->findAll();

        $model = Companies::model()->findAll('category_id = '.$id.' AND checked=1 AND t.status=1');
		$this->render('view',array(
			'model'=>$model,
            //'categories'=>$categories,
		));
	}

	

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
        Yii::app()->clientScript->registerScriptFile('/js/jquery.equal-height-columns.js',  CClientScript::POS_HEAD);

        $categories = CategoriesCompany::model()->findByPk($id);//CategoriesCompany::model()->findAll();

        //количество записей на странице
        $pageSize = '10';
        $cookie = Yii::app()->request->cookies['page_companies']->value;
        if($cookie)
        {
            $pageSize = $cookie;
        }

        $criteria = new CDbCriteria();
        $criteria->compare('category_id',$id);
        $criteria->compare('t.status',1);
        $criteria->compare('city_id',Yii::app()->user->getState('currentCity',1));
        $criteria->compare('checked',1);

		$dataProvider=new CActiveDataProvider('Companies', array(
                    'criteria'=>$criteria,//array(
                        //'condition'=>'category_id='.$id.' AND city_id = '.Yii::app()->user->getState('currentCity',1),
                        //'condition'=>
                    //),
                    'pagination'=>array(
                        'pageSize'=>$pageSize,
                    ),
                ));

        /*if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_loop', array(
                'dataProvider'=>$dataProvider,
            ));
            Yii::app()->end();
        } else {*/
            $this->render('index', array(
                'dataProvider'=>$dataProvider,
                'categories'=>$categories,
            ));
        //}
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
