<?php
/* @var $this ActivatedController */
/* @var $model KuponsActive */

$this->breadcrumbs=array(
	'Kupons Actives'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List KuponsActive', 'url'=>array('index')),
	array('label'=>'Create KuponsActive', 'url'=>array('create')),
	array('label'=>'Update KuponsActive', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete KuponsActive', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage KuponsActive', 'url'=>array('admin')),
);
?>

<h1>View KuponsActive #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'kupon_id',
		'date',
		'utilized',
		'status',
	),
)); ?>
