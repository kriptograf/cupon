<?php
/* @var $this KuponsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Kupons',
);

$this->menu=array(
	array('label'=>'Create Kupons', 'url'=>array('create')),
	array('label'=>'Manage Kupons', 'url'=>array('admin')),
);
?>

<h1>Kupons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
