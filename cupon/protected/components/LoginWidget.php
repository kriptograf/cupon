<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 06.03.13
 * Time: 0:04
 * To change this template use File | Settings | File Templates.
 */
class LoginWidget extends CWidget
{
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        parent::run();
        $this->renderContent();
    }
    public function renderContent()
    {
        Yii::import('application.modules.user.*') ;
        $model = new UserLogin();
        $this->render('login', array('model'=>$model));
    }
}