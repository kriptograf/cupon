<?php
/* @var $this RealtyTypesController */
/* @var $model RealtyTypes */

$this->breadcrumbs=array(
	'Realty Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RealtyTypes', 'url'=>array('index')),
	array('label'=>'Create RealtyTypes', 'url'=>array('create')),
	array('label'=>'View RealtyTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RealtyTypes', 'url'=>array('admin')),
);
?>

<h1>Update RealtyTypes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>