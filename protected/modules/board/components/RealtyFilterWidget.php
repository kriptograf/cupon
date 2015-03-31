<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 08.05.13
 * Time: 18:36
 * To change this template use File | Settings | File Templates.
 */
class RealtyFilterWidget extends CWidget
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
        $this->render('realty_form');
    }
}