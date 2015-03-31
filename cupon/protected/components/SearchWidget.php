<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 05.03.13
 * Time: 22:52
 * To change this template use File | Settings | File Templates.
 */
class SearchWidget extends CWidget
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
        $this->render('search');
    }
}