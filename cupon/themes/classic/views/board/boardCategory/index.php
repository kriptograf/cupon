<?php
/* @var $this BoardCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Board Categories',
);

$this->menu=array(
	array('label'=>'Create BoardCategory', 'url'=>array('create')),
	array('label'=>'Manage BoardCategory', 'url'=>array('admin')),
);
?>

<h1>Board Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
