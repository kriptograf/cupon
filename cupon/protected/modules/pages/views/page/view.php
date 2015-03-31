<?php
/* @var $this PageController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->title,
);
?>

<div class="wrapper layout">
    <div class="wrapper-inner">
        <div class="main-menu">
            <ul class="tab-menu">
                <li class="kupones"><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Купоны</a></li>
                <li class="companies"><a href="<?php echo Yii::app()->createUrl('/companies');?>">Справочник</a></li>
                <li class="boards">Бесплатные объявления</li>
            </ul>
            <div class="btm-line"></div>
        </div><!-- ### end main menu -->

        <div class="equal">
            <div class="main">
                <div class="company-about">
                    <h2><?php echo $model->title; ?></h2>
                </div>
                <div class="noreset">
                        <?php echo $model->text;?>
                </div>
            </div>  <!-- ### end main section -->
            <div class="sidebar">
                <ul class="big-nav">
                    <li><a href="<?php echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>
                    <li><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Все акции</a>
                </ul>
                <ul class="right-menu">
                    <?php foreach($categories as $category):?>
                        <li><a href="<?php echo Yii::app()->createUrl('/category/'.$category->id);?>"><?php echo $category->name;?> <span class="count-cat"><?php echo $category->countKupons; ?></span></a></li>
                    <?php endforeach;?>
                </ul>
            </div>  <!-- ### end sidebar section -->
        </div>

    </div>
</div>

