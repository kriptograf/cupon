<?php
/* @var $this StatisticController */
/* @var $model StatBanner */

$this->breadcrumbs=array(
	'Stat Banners'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StatBanner', 'url'=>array('index')),
	array('label'=>'Create StatBanner', 'url'=>array('create')),
	array('label'=>'Update StatBanner', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StatBanner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StatBanner', 'url'=>array('admin')),
);
?>

<h1>View StatBanner #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'banner_id',
		'date',
		'city_id',
		'pos_id',
	),
)); ?>
