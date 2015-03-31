<?php
/* @var $this RealtyController */
/* @var $model Realty */

$this->breadcrumbs=array(
	'Realties'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Realty', 'url'=>array('index')),
	array('label'=>'Manage Realty', 'url'=>array('admin')),
);
?>

<h1>Create Realty</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>