<?php
/* @var $this GoodsImgController */
/* @var $model GoodsImg */

$this->breadcrumbs=array(
	'Goods Imgs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GoodsImg', 'url'=>array('index')),
	array('label'=>'Create GoodsImg', 'url'=>array('create')),
	array('label'=>'View GoodsImg', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GoodsImg', 'url'=>array('admin')),
);
?>

<h1>Update GoodsImg <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>