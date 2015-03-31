<?php
/**
 * Created by JetBrains PhpStorm.
 * User: foreach
 * Date: 07.03.13
 * Time: 19:23
 * To change this template use File | Settings | File Templates.
 */
class FrontNewsWidget extends CWidget
{
    public function init()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/facebox/facebox.js', CClientScript::POS_HEAD);
        parent::init();
    }
    public function run()
    {
        $this->renderContent();
        parent::run();
    }
    public function renderContent()
    {
        Yii::app()->clientScript->registerScriptFile('/js/news-scroll.js',  CClientScript::POS_HEAD);
        $news = News::model()->findAll('id_city='.Yii::app()->user->getState('currentCity',1));

        //$content = $this->crop_news($news->content, 70).' ...';
        $this->render('news', array('news'=>$news));
    }

}