<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 05.04.13
 * Time: 19:50
 * To change this template use File | Settings | File Templates.
 */
class SocialWidget extends CWidget
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
        $buttons = Social::model()->findAll('status=:st',array(':st'=>1));
        if(!$buttons)
        {
            return false;
        }
        $this->render('social',array('buttons'=>$buttons));
    }
}