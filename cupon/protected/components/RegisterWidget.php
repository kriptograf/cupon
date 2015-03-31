<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 06.03.13
 * Time: 0:06
 * To change this template use File | Settings | File Templates.
 */
class RegisterWidget extends CWidget
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
        $model = new RegistrationForm;
        $profile=new Profile;
        $profile->regMode = true;

        $this->render('register', array(
            'model'=>$model,
            'profile'=>$profile,
        ));
    }
}