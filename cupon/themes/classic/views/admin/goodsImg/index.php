<?php
/* @var $this GoodsImgController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Goods Imgs',
);

$this->menu=array(
	array('label'=>'Create GoodsImg', 'url'=>array('create')),
	array('label'=>'Manage GoodsImg', 'url'=>array('admin')),
);
?>

<h1>Goods Imgs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
