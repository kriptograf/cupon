<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 06.05.13
 * Time: 21:01
 * To change this template use File | Settings | File Templates.
 */

class GetSubCatController extends Controller
{
    public function actionIndex()
    {
        if(isset($_POST))
        {
            $subcat = CategoriesCompany::model()->findAllByAttributes(array('parent_id'=>$_POST['parent_id']));

            $data=CHtml::listData($subcat,'id','name');
            echo CHtml::tag('option',array('value'=>''),'-Выберите подкатегорию-',true);
            foreach($data as $value=>$name)
            {
                echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
            }
        }
    }

}