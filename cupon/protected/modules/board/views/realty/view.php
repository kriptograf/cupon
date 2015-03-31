<?php
/* @var $this RealtyController */
/* @var $model Realty */

$this->breadcrumbs=array(
	'Realties'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Realty', 'url'=>array('index')),
	array('label'=>'Create Realty', 'url'=>array('create')),
	array('label'=>'Update Realty', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Realty', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Realty', 'url'=>array('admin')),
);
?>

<h1>View Realty #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category_id',
		'city_id',
		'user_id',
		'type_id',
		'title',
		'area',
		'rooms',
		'details',
		'price',
		'author',
		'email',
		'phone',
		'address',
		'date_pub',
		'date_end',
		'checked',
		'views',
		'status',
		'x',
		'y',
	),
)); ?>
