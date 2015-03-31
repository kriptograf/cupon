<?php
/* @var $this RealtyTypesController */
/* @var $model RealtyTypes */

$this->breadcrumbs=array(
	'Realty Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RealtyTypes', 'url'=>array('index')),
	array('label'=>'Manage RealtyTypes', 'url'=>array('admin')),
);
?>

<h1>Create RealtyTypes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>