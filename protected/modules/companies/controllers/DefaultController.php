<?php
/**
 * Контроллер запускается при переходе на страницу справочника компаний
 */
class DefaultController extends Controller
{

    public function actionIndex()
    {
       Yii::app()->clientScript->registerCssFile('/css/ui.css');

        $criteria = new CDbCriteria();
        $criteria->compare('status', 1);

        /**
         * Категории компаний
         */
        $categories = CategoriesCompany::model()->findAll($criteria);

        /*$criteria = new CDbCriteria();
        $criteria->compare('city_id', 1);

        $total = Companies::model()->count($criteria);

        $pages = new CPagination($total);
        $pages->pageSize = 1;
        $pages->applyLimit($criteria);


        $dataProvider = new CActiveDataProvider('Companies', array(
            'criteria' => array(
                'condition' => 'city_id=1',
            //'order'=>'RAND()',
            ),
            'pagination' => array(
                'pageSize' => 1,
            ),
        ));*/
        $this->render('index', array(
            //'dataProvider' => $dataProvider,
            'categories' => $categories,
        ));
    }

}