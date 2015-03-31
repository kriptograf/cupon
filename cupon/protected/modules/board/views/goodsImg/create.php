<?php
/* @var $this GoodsImgController */
/* @var $model GoodsImg */

$this->breadcrumbs=array(
	'Goods Imgs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GoodsImg', 'url'=>array('index')),
	array('label'=>'Manage GoodsImg', 'url'=>array('admin')),
);
?>

<h1>Create GoodsImg</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>