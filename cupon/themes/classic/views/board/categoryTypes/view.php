<?php
/* @var $this CategoryTypesController */
/* @var $model CategoryTypes */

$this->breadcrumbs=array(
	'Category Types'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CategoryTypes', 'url'=>array('index')),
	array('label'=>'Create CategoryTypes', 'url'=>array('create')),
	array('label'=>'Update CategoryTypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CategoryTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoryTypes', 'url'=>array('admin')),
);
?>

<h1>View CategoryTypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category_id',
		'type_id',
	),
)); ?>
