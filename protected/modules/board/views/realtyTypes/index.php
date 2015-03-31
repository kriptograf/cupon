<?php
/* @var $this RealtyTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Realty Types',
);

$this->menu=array(
	array('label'=>'Create RealtyTypes', 'url'=>array('create')),
	array('label'=>'Manage RealtyTypes', 'url'=>array('admin')),
);
?>

<h1>Realty Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
