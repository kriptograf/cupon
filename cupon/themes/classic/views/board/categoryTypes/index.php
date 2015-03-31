<?php
/* @var $this CategoryTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Category Types',
);

$this->menu=array(
	array('label'=>'Create CategoryTypes', 'url'=>array('create')),
	array('label'=>'Manage CategoryTypes', 'url'=>array('admin')),
);
?>

<h1>Category Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
