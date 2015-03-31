<?php
/* @var $this RealtyCategoryController */
/* @var $model RealtyCategory */

$this->breadcrumbs=array(
	'Realty Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List RealtyCategory', 'url'=>array('index')),
	array('label'=>'Create RealtyCategory', 'url'=>array('create')),
	array('label'=>'Update RealtyCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RealtyCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RealtyCategory', 'url'=>array('admin')),
);
?>

<h1>View RealtyCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
		'apartments',
	),
)); ?>
