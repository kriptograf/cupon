<?php
/* @var $this AutoCategoryController */
/* @var $model AutoCategory */

$this->breadcrumbs=array(
	'Auto Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AutoCategory', 'url'=>array('index')),
	array('label'=>'Create AutoCategory', 'url'=>array('create')),
	array('label'=>'Update AutoCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AutoCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AutoCategory', 'url'=>array('admin')),
);
?>

<h1>View AutoCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
		'flag_type',
	),
)); ?>
