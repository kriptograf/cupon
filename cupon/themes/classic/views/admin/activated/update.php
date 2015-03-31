<?php
/* @var $this ActivatedController */
/* @var $model KuponsActive */

$this->breadcrumbs=array(
	'Kupons Actives'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List KuponsActive', 'url'=>array('index')),
	array('label'=>'Create KuponsActive', 'url'=>array('create')),
	array('label'=>'View KuponsActive', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage KuponsActive', 'url'=>array('admin')),
);
?>

<h1>Update KuponsActive <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>