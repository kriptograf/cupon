<?php
/* @var $this KuponsController */
/* @var $model Kupons */

$this->breadcrumbs=array(
	'Kupons'=>array('index'),
	$model->id_kupon=>array('view','id'=>$model->id_kupon),
	'Update',
);

$this->menu=array(
	array('label'=>'List Kupons', 'url'=>array('index')),
	array('label'=>'Create Kupons', 'url'=>array('create')),
	array('label'=>'View Kupons', 'url'=>array('view', 'id'=>$model->id_kupon)),
	array('label'=>'Manage Kupons', 'url'=>array('admin')),
);
?>

<h1>Update Kupons <?php echo $model->id_kupon; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>