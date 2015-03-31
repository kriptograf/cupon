<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	'News'=>array('index'),
	$model->title,
);
?>
<div class="news-container">
    <h1><?php echo $model->title; ?></h1>
    <div class="date"><?php echo $model->CreatedDate;?></div>
    <div class="news-image">
        <img src="/content/news/<?php echo $model->image;?>">
    </div>
    <div class="news-content">
        <?php echo  $model->content;?>
    </div>
</div>

