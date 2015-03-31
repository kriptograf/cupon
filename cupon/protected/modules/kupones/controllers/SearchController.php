<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 30.03.13
 * Time: 23:53
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

            $catKupones = CategoriesKupon::model()->findAll();

            $criteria = new CDbCriteria();
            $criteria->addSearchCondition('action',$query);
            $criteria->addCondition('city_id='.Yii::app()->user->getState('currentCity',1));


            $kupones = Kupons::model()->findAll($criteria);

            $this->render('index', array(
                'catKupones'=>$catKupones,
                'model'=>$kupones,
                'query'=>$query,
            ));
        }
        else
        {
            $this->redirect('/');
        }

    }

}