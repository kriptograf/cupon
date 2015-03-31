<?php
/* @var $this CompaniesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Companies',
);

/*$this->menu=array(
    array('label'=>'Create Companies', 'url'=>array('create')),
    array('label'=>'Manage Companies', 'url'=>array('admin')),
);  */
?>

<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
        <div class="main">
            <div class="title-companies">
                <!--<img src="/images/cat-company.png" alt="Справочник компаний" />-->
                Справочник
            </div>
            
            <div class="company-wrapper">
                <div class="add-company">
                    <span class="add-title">Добавьте вашу организацию прямо сейчас</span>
                    <a href="/companies/create" class="btn-add"><span>Добавить</span></a>
                </div>
            <?php /*$this->widget('zii.widgets.CListView', array(
                'id'=>'list-company',
                'dataProvider'=>$dataProvider,
                'itemView'=>'_view',
                'template' => '{items} {pager}',
                'pager' => array(
                    'class' => 'ext.infiniteScroll.IasPager',
                    'rowSelector'=>'.view',
                    'listViewId' => 'list-company',
                    'header' => '',
                    'loaderText'=>'<img src="/images/ajax-loader.gif">',//'Загружаются еще ...',
                    'options' => array(
                        'history' => false,
                        'triggerPageTreshold' => 3,
                        'trigger'=>'Показать еще',
                        'thresholdMargin'=>-250
                    ),
                )
            )); */?>
                <div class="list-cat">
                    <?php $i=1;?>
                    <div class="spacer-three">
                        <?php foreach ($categories as $parent):?>
                            <?php if($parent->parent_id===NULL):?>
                            <div class="item-category">
                                <div class="parent">
                                    <span class="parent-span"><?php echo $parent->name;?></span>
                                    <?php if($parent->childs):?>
                                    <div class="childs">
                                        <?php foreach ($parent->childs as $child):?>
                                        <a href="<?php echo Yii::app()->createUrl('/category/'.$child->id);?>"><?php echo $child->name;?></a><br />
                                        <?php endforeach;?>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                                <?php if($i==3):?>
                                </div><div class="spacer-three">
                                    <?php $i=0;?>
                                <?php endif;?>
                            <?php else:?>
                            <?php continue;?>
                            <?php endif;?>
                        <?php $i++;?>
                        <?php endforeach;?>
                    </div>
                </div>
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
<!--            <ul class="right-menu">
                <?php //foreach($categories as $category):?>
                    <li><a href="<?php //echo Yii::app()->createUrl('/category/'.$category->id);?>"><?php //echo $category->name;?> <span class="count-cat"><?php //echo $category->countCompanies; ?></span></a></li>
                <?php //endforeach;?>
            </ul>-->
        </div>  <!-- ### end sidebar section -->
        <?php        
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'addform',
                // additional javascript options for the dialog plugin
                'options' => array(
                    'title' => '<div id="form-title">Добавить организацию</div>',
                    'autoOpen' => false,
                    'width'=>'638',
                ),
            ));
            
            $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        /*$('.btn-add').click(function(event){
            event.preventDefault();
            $.get('/companies/create',function(data){
                $('#addform').html(data);
              });
        });*/
    });
</script>
