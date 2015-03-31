<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 04.04.13
 * Time: 17:36
 * To change this template use File | Settings | File Templates.
 */
class MenuWidget extends CWidget
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
        $this->render('menu');
    }
}