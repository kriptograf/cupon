<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 01.04.13
 * Time: 17:43
 * To change this template use File | Settings | File Templates.
 */
class SearchController extends Controller
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
                'actions'=>array('index'),
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $query = $_POST['query'];

            $categories = CategoriesCompany::model()->findAll();

            $criteria = new CDbCriteria();
            $criteria->addSearchCondition('title',$query);
            $criteria->addSearchCondition('description',$query,true,'OR');
            $criteria->addCondition('city_id='.Yii::app()->user->getState('currentCity',1));


            $dataProvider=new CActiveDataProvider('Companies', array(
                'criteria'=>$criteria,
            ));
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
                'categories'=>$categories,
                'query'=>$query,
            ));
        }
        else
        {
            $this->redirect('/');
        }

    }

}