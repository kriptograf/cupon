<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Create',
);
?>
<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">
                <div id="form-title" class="title-companies">
                    Добавление новой компании
                </div>
                <?php echo $this->renderPartial('_form', array(
                    'model'=>$model,
                    'gallery'=>$gallery,
                    'news'=>$news,
                    'user'=>$user,
                )); ?>
            </div>


            <div class="sidebar">
                <ul class="big-nav">
                    <!--                <li><a href="<?php //echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>-->
                    <li><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Все акции</a>
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