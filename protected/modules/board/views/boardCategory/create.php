<?php
/* @var $this BoardCategoryController */
/* @var $model BoardCategory */

$this->breadcrumbs=array(
	'Board Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BoardCategory', 'url'=>array('index')),
	array('label'=>'Manage BoardCategory', 'url'=>array('admin')),
);
?>

<h1>Create BoardCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>