<?php
/* @var $this BoardCategoryController */
/* @var $model BoardCategory */

$this->breadcrumbs=array(
	'Board Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BoardCategory', 'url'=>array('index')),
	array('label'=>'Create BoardCategory', 'url'=>array('create')),
	array('label'=>'View BoardCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BoardCategory', 'url'=>array('admin')),
);
?>

<h1>Update BoardCategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>