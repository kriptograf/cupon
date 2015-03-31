<?php
/* @var $this AutoTypesController */
/* @var $model AutoTypes */

$this->breadcrumbs=array(
	'Auto Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AutoTypes', 'url'=>array('index')),
	array('label'=>'Create AutoTypes', 'url'=>array('create')),
	array('label'=>'Update AutoTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AutoTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AutoTypes', 'url'=>array('admin')),
);
?>

<h1>View AutoTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'title',
		'status',
	),
)); ?>
