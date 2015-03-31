<?php
/* @var $this KuponsController */
/* @var $model Kupons */

$this->breadcrumbs=array(
	'Kupons'=>array('index'),
	$model->id_kupon,
);

$this->menu=array(
	array('label'=>'List Kupons', 'url'=>array('index')),
	array('label'=>'Create Kupons', 'url'=>array('create')),
	array('label'=>'Update Kupons', 'url'=>array('update', 'id'=>$model->id_kupon)),
	array('label'=>'Delete Kupons', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_kupon),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Kupons', 'url'=>array('admin')),
);
?>

<h1>View Kupons #<?php echo $model->id_kupon; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_kupon',
		'action',
		'city_id',
		'cat_id',
		'company_id',
		'image',
		'code',
		'old_price',
		'new_price',
		'conditions',
		'details',
		'start_date',
		'end_date',
		'status',
		'position',
		'rating',
		'views',
	),
)); ?>
