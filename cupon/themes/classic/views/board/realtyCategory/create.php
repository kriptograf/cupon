<?php
/* @var $this RealtyCategoryController */
/* @var $model RealtyCategory */

$this->breadcrumbs=array(
	'Realty Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RealtyCategory', 'url'=>array('index')),
	array('label'=>'Manage RealtyCategory', 'url'=>array('admin')),
);
?>

<h1>Create RealtyCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>