<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 01.04.13
 * Time: 0:34
 * To change this template use File | Settings | File Templates.
 */
Yii::import('ext.infiniteScroll.IasPager');
class AIasPager extends IasPager {

    public $countPage;
    public $listViewId;
    public $rowSelector = '.row';
    public $itemsSelector = ' > .items';
    public $nextSelector = '.next:not(.disabled):not(.hidden) a';
    public $pagerSelector = '.pager';
    public $options = array();
    public $linkOptions = array();
    public $loaderText = 'Loading...';
    private $baseUrl;


    public function init() {

        parent::init();

        $assets = dirname(__FILE__) . '/assets';
        $this->baseUrl = Yii::app()->assetManager->publish($assets);

        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCSSFile($this->baseUrl . '/css/jquery.ias.css');

        if (YII_DEBUG)
            $cs->registerScriptFile($this->baseUrl . '/js/jquery.ias.js', CClientScript::POS_END);
        else
            $cs->registerScriptFile($this->baseUrl . '/js/jquery-ias.min.js', CClientScript::POS_END);
        return;
    }

    public function run() {

        $js = "jQuery.ias(" .
            CJavaScript::encode(
                CMap::mergeArray($this->options, array(
                    'container' => '#' . $this->listViewId . '' . $this->itemsSelector,
                    'item' => $this->rowSelector,
                    'pagination' => '#' . $this->listViewId . ' ' . $this->pagerSelector,
                    'next' => '#' . $this->listViewId . ' ' . $this->nextSelector,
                    'loader' => $this->loaderText,
                ))) . ");";


        $cs = Yii::app()->clientScript;
        $cs->registerScript(__CLASS__ . $this->id, $js, CClientScript::POS_READY);


        $buttons = $this->createPageButtons($this->countPage);

        echo $this->header; // if any
        echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
        echo $this->footer;  // if any
    }

    protected function createPageButton($label, $page, $class, $hidden, $selected) {
        if ($hidden || $selected)
            $class .= ' ' . ($hidden ? 'disabled' : 'active');

        return CHtml::tag('li', array('class' => $class), CHtml::link($label, $this->createPageUrl($page), $this->linkOptions));
    }

    /**
     * Creates the page buttons.
     * @return array a list of page buttons (in HTML code).
     */
    protected function createPageButtons($countPage)
    {
        if($countPage<=1)
            return array();

        list($beginPage,$endPage)=$this->getPageRange();
        $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons=array();

        // first page
        $buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);

        // prev page
        if(($page=$currentPage-1)<0)
            $page=0;
        $buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

        // internal pages
        for($i=$beginPage;$i<=$endPage;++$i)
            $buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

        // next page
        if(($page=$currentPage+1)>=$countPage-1)
            $page=$countPage-1;
        $buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$countPage-1,false);

        // last page
        $buttons[]=$this->createPageButton($this->lastPageLabel,$countPage-1,$this->lastPageCssClass,$currentPage>=$countPage-1,false);

        return $buttons;
    }

}