<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 08.04.13
 * Time: 16:52
 * To change this template use File | Settings | File Templates.
 */
class EndCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        Yii::import('application.modules.kupones.models.Kupons');
        date_default_timezone_set('Europe/Moscow');

        $time = date('Y-m-d H:i',time());

        $criteria = new CDbCriteria();
        $criteria->condition = 'date_end < '.$time;

        $model = Kupons::model()->findAll($criteria);

        if($model)
        {
            $model->status = 0;
            if($model->save())
            {
                echo 'work is Index - '.$time;
            }
            else
            {
                echo 'error save';
            }
        }
        else
        {
            echo 'not models';
        }
    }
}