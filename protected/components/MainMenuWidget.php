<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 07.05.13
 * Time: 17:13
 * To change this template use File | Settings | File Templates.
 */
class MainMenuWidget extends CWidget
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
        $this->render('main_menu');
    }
}