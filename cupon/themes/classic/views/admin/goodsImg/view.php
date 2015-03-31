<?php
/* @var $this GoodsImgController */
/* @var $model GoodsImg */

$this->breadcrumbs=array(
	'Goods Imgs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GoodsImg', 'url'=>array('index')),
	array('label'=>'Create GoodsImg', 'url'=>array('create')),
	array('label'=>'Update GoodsImg', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GoodsImg', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GoodsImg', 'url'=>array('admin')),
);
?>

<h1>View GoodsImg #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'goods_id',
		'img',
		'thumb',
		'status',
	),
)); ?>
