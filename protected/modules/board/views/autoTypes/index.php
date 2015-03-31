<?php
/* @var $this AutoTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auto Types',
);

$this->menu=array(
	array('label'=>'Create AutoTypes', 'url'=>array('create')),
	array('label'=>'Manage AutoTypes', 'url'=>array('admin')),
);
?>

<h1>Auto Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
