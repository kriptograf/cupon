<?php
/* @var $this ActivatedController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Kupons Actives',
);

$this->menu=array(
	array('label'=>'Create KuponsActive', 'url'=>array('create')),
	array('label'=>'Manage KuponsActive', 'url'=>array('admin')),
);
?>

<h1>Kupons Actives</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
