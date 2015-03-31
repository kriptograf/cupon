<?php
/* @var $this PositionController */
/* @var $model PosBanner */

$this->breadcrumbs=array(
	'Pos Banners'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List PosBanner', 'url'=>array('index')),
	array('label'=>'Create PosBanner', 'url'=>array('create')),
	array('label'=>'Update PosBanner', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PosBanner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PosBanner', 'url'=>array('admin')),
);
?>

<h1>View PosBanner #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'pos',
		'title',
		'description',
	),
)); ?>
