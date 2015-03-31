<?php
/* @var $this AdsController */
/* @var $model Ads */

$this->breadcrumbs=array(
	'Ads'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Ads', 'url'=>array('index')),
	array('label'=>'Create Ads', 'url'=>array('create')),
	array('label'=>'Update Ads', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Ads', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ads', 'url'=>array('admin')),
);
?>

<h1>View Ads #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category_id',
		'city_id',
		'user_id',
		'type_id',
		'title',
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
	),
)); ?>
