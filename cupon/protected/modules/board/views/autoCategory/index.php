<?php
/* @var $this AutoCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auto Categories',
);

$this->menu=array(
	array('label'=>'Create AutoCategory', 'url'=>array('create')),
	array('label'=>'Manage AutoCategory', 'url'=>array('admin')),
);
?>

<h1>Auto Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
