<?php
/* @var $this KuponsController */
/* @var $model Kupons */

$this->breadcrumbs=array(
	'Kupons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Kupons', 'url'=>array('index')),
	array('label'=>'Manage Kupons', 'url'=>array('admin')),
);
?>

<h1>Create Kupons</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>