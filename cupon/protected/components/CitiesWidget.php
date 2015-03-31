<?php

class CitiesWidget extends CWidget
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
        $cities = Cities::model()->findAll();
        $current = Cities::model()->findByPk(Yii::app()->user->getState('currentCity',1));
        $this->render('cities', array('cities'=>$cities, 'current'=>$current));
    }
}
