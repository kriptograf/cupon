<?php
/* @var $this MyAdsController */

$this->breadcrumbs=array(
	'My Ads',
);
?>
<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">

                <div id="form-title" class="title-section">
                    <h1 class="section-h1">Мои объявления</h1>

                    <span class="add-board">
                        <a href="/board/ads/create">Добавить объявление</a>
                    </span>
                    <span class="count-board">Объявлений / <?php echo $dataProvider->totalItemCount;?></span>
                </div>

                <!-- filter-->
                <?php //$this->widget('FilterWidget');?>

                <!-- ### ajax infinity pagination widget -->
                <?php
                $count_records = (isset(Yii::app()->request->cookies['page_board']->value))?Yii::app()->request->cookies['page_board']->value:'';
                $pageSize=$count_records;
                if(!$count_records)
                {
                    $count_records=25;
                    $pageSize=25;
                }

                $footer = $this->renderPartial('footer',array('count_records'=>$count_records),true,false);
                ?>
                <div class="spacer"></div>
                <?php //echo CHtml::beginForm('/board/myAds/bulkDelete','post',array('id'=>'bulk-form'));?>

                <?php
                $this->widget('EListView', array(
                        'id' => 'list-actions',
                        'dataProvider' => $dataProvider,
                        'ajaxUpdate'=>'list-actions',
                        'itemView' => '_view',
                        //'sorterHeader'=>'',
                        //'sorterFooter'=>'<input type="checkbox" id="checkall"><label for="checkall" id="lblcheckall">Выделить все</label> <a id="ext" href="#">Продлить выбранные / </a> <a id="massdel" href="#">Удалить навсегда</a> ',
                        //'summaryText'=>'Найдено объявлений: {count}',
                        'template' => '{items}',
                        'enableSorting'=>false,
                        //'sorterCssClass'=>'my-filter-sorting sort',
                        //'summaryCssClass'=>'board-summary',
                        /*'pager'=>array(
                            'cssFile'=>'/css/superpager.css',
                            'header'=>'Страницы: ',
                            'maxButtonCount'=>6,
                            'pageSize'=>$pageSize,
                            'prevPageLabel'  => '<img src="/images/pagination/left.png">',
                            'nextPageLabel'  => '<img src="/images/pagination/right.png">',
                        ),*/
                        /*'sortableAttributes'=>array(
                            'status'=>'Не активные / Активные',
                        ),*/
                        //'links'=>$footer,
                    )
                );
                ?>

                <?php
                $this->widget('EListView', array(
                        'id' => 'realty-list-actions',
                        'dataProvider' => $realty,
                        'ajaxUpdate'=>'realty-list-actions',
                        'itemView' => '_view_realty',
                        'template' => '{items}',
                        'enableSorting'=>false,
                    )
                );
                ?>
                <?php //echo CHtml::endForm()?>
                <script>
                    /*$(document).ready(function(){
                        $('#checkall').change(function(){
                            $("input[type='checkbox']").attr('checked','checked');
                        });
                        $('#ext').click(function(){
                            $('#bulk-form').attr('action','/board/myAds/bulkExt');
                            $('#bulk-form').submit();
                        });
                    });*/
                </script>
            </div>  <!-- ### end main section -->

            <div class="sidebar">
                <?php $this->widget('SectionsWidget');?>
            </div>  <!-- ### end sidebar section -->
        </div>
    </div>
</div>
