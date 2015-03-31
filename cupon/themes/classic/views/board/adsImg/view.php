<?php
/* @var $this AdsImgController */
/* @var $model AdsImg */

$this->breadcrumbs=array(
	'Ads Imgs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AdsImg', 'url'=>array('index')),
	array('label'=>'Create AdsImg', 'url'=>array('create')),
	array('label'=>'Update AdsImg', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AdsImg', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AdsImg', 'url'=>array('admin')),
);
?>

<h1>View AdsImg #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ads_id',
		'img',
		'thumb',
		'status',
	),
)); ?>
