<?php
/* @var $this RealtyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Realties',
);

$this->menu=array(
	array('label'=>'Create Realty', 'url'=>array('create')),
	array('label'=>'Manage Realty', 'url'=>array('admin')),
);
?>

<h1>Realties</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
