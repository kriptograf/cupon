<?php
/* @var $this RealtyImgController */
/* @var $model RealtyImg */

$this->breadcrumbs=array(
	'Realty Imgs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RealtyImg', 'url'=>array('index')),
	array('label'=>'Create RealtyImg', 'url'=>array('create')),
	array('label'=>'Update RealtyImg', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RealtyImg', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RealtyImg', 'url'=>array('admin')),
);
?>

<h1>View RealtyImg #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ads_id',
		'img',
		'thumb',
		'status',
	),
)); ?>
