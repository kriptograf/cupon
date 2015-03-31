<?php
/* @var $this CategoriesCompanyController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	$categories->name,
);

/*$this->menu=array(
	array('label'=>'Create CategoriesCompany', 'url'=>array('create')),
	array('label'=>'Manage CategoriesCompany', 'url'=>array('admin')),
);  */
?>


<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
        <div class="main">
            <div class="title-companies">
                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                	'separator'=>' / ',
                    'links'=>$this->breadcrumbs,
                    'homeLink'=>CHtml::link('Справочник',Yii::app()->createUrl('/companies')),
                	//'htmlOptions'=>array('class'=>'well well-small'),
                )); ?><!-- breadcrumbs -->
            </div>
            
            <div class="company-wrapper">
                <div class="catalog">Справочник компаний</div>
                <?php
                $count_records = Yii::app()->request->cookies['page_companies']->value;
                if(!$count_records)
                {
                    $count_records=10;
                }

                $footer = $this->renderPartial('footer',array('count_records'=>$count_records),true,false);
                ?>
                <?php //$this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>
                <?php $this->widget('EListView', array(
                //$this->widget('application.modules.companies.components.TListView', array(
                    'id' => 'list-actions',
                    'dataProvider'=>$dataProvider,
                    'itemsTagName'=>'table',
                    'itemView'=>'_viewtable',
                    'summaryText'=>false,
                    'ajaxUpdate'=>true,
                    'template' => '{items} {pager} {sizer}',
                    /*'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector'=>'.separator',
                        'listViewId' => 'list-actions',
                        'header' => '',
                        'loaderText'=>'<img src="/images/ajax-loader.gif">',//'Загружаются еще ...',
                        'options' => array(
                            'history' => false,
                            'triggerPageTreshold' => 10,
                            'trigger'=>'Показать еще',
                            'thresholdMargin'=>-300
                        ),
                    )*/
                    'pager'=>array(
                        'cssFile'=>'/css/superpager.css',
                        'header'=>'Страницы: ',
                        'maxButtonCount'=>6,
                        'pageSize'=>$pageSize,
                        'prevPageLabel'  => '<img src="/images/pagination/left.png">',
                        'nextPageLabel'  => '<img src="/images/pagination/right.png">',
                    ),
                    'links'=>$footer,
                ));
                ?>
                <?php Yii::app()->getClientScript()->registerCssFile( Yii::app()->baseUrl.'/css/jquery.comprating.css', 'screen, projection');?>
                <?php Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.rating-2.0.js' , CClientScript::POS_HEAD);?>
                <?php Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/comprate.js' , CClientScript::POS_HEAD);?>
            </div>

            </div>  <!-- ### end main section -->

        <div class="sidebar">
            <ul class="big-nav">
<!--                <li><a href="<?php //echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>-->
                <li><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Все акции</a> </li>
            </ul>
             <?php $this->widget('CTreeView', 
                    array(
                        'id'=>'treecategory',
                        'cssFile'=>'/css/jquery.treeview.css',
                        'data' => CategoriesCompany::generateTree(),
                        'collapsed'=>true,
                        'persist'=>'cookie',
                        'animated'=>'slow',
                        'htmlOptions'=>array(
                            'class'=>'right-menu'
                        ),
                        )
                    ); 
            ?>

        </div>  <!-- ### end sidebar section -->
        </div>

    </div>
</div>


