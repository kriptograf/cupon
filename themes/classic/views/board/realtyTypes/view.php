<?php
/* @var $this RealtyTypesController */
/* @var $model RealtyTypes */

$this->breadcrumbs=array(
	'Realty Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List RealtyTypes', 'url'=>array('index')),
	array('label'=>'Create RealtyTypes', 'url'=>array('create')),
	array('label'=>'Update RealtyTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RealtyTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RealtyTypes', 'url'=>array('admin')),
);
?>

<h1>View RealtyTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'title',
		'status',
	),
)); ?>
