<?php
/* @var $this AdsImgController */
/* @var $model AdsImg */

$this->breadcrumbs=array(
	'Ads Imgs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdsImg', 'url'=>array('index')),
	array('label'=>'Create AdsImg', 'url'=>array('create')),
	array('label'=>'View AdsImg', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AdsImg', 'url'=>array('admin')),
);
?>

<h1>Update AdsImg <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>