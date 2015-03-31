<?php
/* @var $this AutoImgController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auto Imgs',
);

$this->menu=array(
	array('label'=>'Create AutoImg', 'url'=>array('create')),
	array('label'=>'Manage AutoImg', 'url'=>array('admin')),
);
?>

<h1>Auto Imgs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
