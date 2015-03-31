<?php
/* @var $this RealtyController */
/* @var $model Realty */

$this->breadcrumbs=array(
	'Realties'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Realty', 'url'=>array('index')),
	array('label'=>'Create Realty', 'url'=>array('create')),
	array('label'=>'View Realty', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Realty', 'url'=>array('admin')),
);
?>

<h1>Update Realty <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>