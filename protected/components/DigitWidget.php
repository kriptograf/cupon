<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 21.03.13
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */
class DigitWidget extends CWidget
{
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        $this->renderContent();
        parent::run();
    }
    public function renderContent()
    {
        $criteria = new CDbCriteria;

        $criteria->select = array(
            'SUM(diff) as economy',
        );
        $criteria->compare('city_id', Yii::app()->user->getState('currentCity',1));

        $economy = Kupons::model()->find($criteria);
        $this->render('digit', array('economy'=>$economy));
    }
}