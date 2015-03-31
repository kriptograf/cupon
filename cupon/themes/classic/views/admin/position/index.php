<?php
/* @var $this PositionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pos Banners',
);

$this->menu=array(
	array('label'=>'Create PosBanner', 'url'=>array('create')),
	array('label'=>'Manage PosBanner', 'url'=>array('admin')),
);
?>

<h1>Pos Banners</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
