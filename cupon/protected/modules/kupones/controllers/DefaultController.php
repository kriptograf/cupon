<?php

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $catKupones = CategoriesKupon::model()->findAll('1 ORDER BY name');

        //количество записей на странице
        $pageSize = '15';
        $cookie = Yii::app()->request->cookies['page_kupones']->value;
        if($cookie)
        {
            $pageSize = $cookie;
        }

//        $kupones = Kupons::model()->findAll();
//
//        $this->render('index', array(
//            'catKupones' => $catKupones,
//            'model' => $kupones,
//        ));
        
        $criteria = new CDbCriteria();
        $criteria->compare('t.city_id',Yii::app()->user->getState('currentCity',1));
        $criteria->compare('t.status',1);
        $criteria->with=array('company'=>array('company.checked'=>1));
        $criteria->compare('company.checked',1);

        $total = Kupons::model()->count($criteria);

        $pages = new CPagination($total);
        $pages->pageSize = $pageSize;
        $pages->applyLimit($criteria);

        $this->render('index', array(
                'catKupones'=>$catKupones,
                'dataProvider'=>new CActiveDataProvider('Kupons',array(
                    'criteria'=>array(
                        'with'   => array('company'=>array('company.checked'=>1)),
                        'condition'=>'t.city_id='.Yii::app()->user->getState('currentCity',1).' AND company.checked=1 AND t.status=1',
                    ),
                    'pagination'=>array(
                        'pageSize'=>$pageSize,
                    ),
                )),
        ));
    }

}