<?php
/* @var $this CategoriesCompanyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Categories Companies',
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
                    <img src="/images/cat-company.png" alt="Справочник компаний" />
                </div>
                <h3 id="h-s">Результаты поиска компаний по запросу: <span id="s-q"><?php echo CHtml::encode($query);?></span></h3>
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$dataProvider,
                    'summaryText'=>'Найдено: {count}',
                    'itemView'=>'_view',
                )); ?>


            </div>  <!-- ### end main section -->
            <div class="sidebar">
                <ul class="big-nav">
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
                
<!--                <ul class="right-menu">
                    <?php //foreach($categories as $category):?>
                        <li><a href="<?php //echo Yii::app()->createUrl('/category/'.$category->id);?>"><?php //echo $category->name;?> <span class="count-cat"><?php //echo $category->countCompanies; ?></span></a></li>
                    <?php //endforeach;?>
                </ul>-->
            </div>  <!-- ### end sidebar section -->
        </div>

    </div>
</div>


