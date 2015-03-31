<?php
/* @var $this BoardCategoryController */
/* @var $model BoardCategory */

$this->breadcrumbs=array(
	'Board Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List BoardCategory', 'url'=>array('index')),
	array('label'=>'Create BoardCategory', 'url'=>array('create')),
	array('label'=>'Update BoardCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BoardCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BoardCategory', 'url'=>array('admin')),
);
?>

<h1>View BoardCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'section_id',
		'status',
	),
)); ?>
