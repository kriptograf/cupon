<?php
/* @var $this AutoImgController */
/* @var $model AutoImg */

$this->breadcrumbs=array(
	'Auto Imgs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AutoImg', 'url'=>array('index')),
	array('label'=>'Create AutoImg', 'url'=>array('create')),
	array('label'=>'Update AutoImg', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AutoImg', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AutoImg', 'url'=>array('admin')),
);
?>

<h1>View AutoImg #<?php echo $model->id; ?></h1>

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
