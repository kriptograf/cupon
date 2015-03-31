<?php
/* @var $this AutoCategoryController */
/* @var $model AutoCategory */

$this->breadcrumbs=array(
	'Auto Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AutoCategory', 'url'=>array('index')),
	array('label'=>'Create AutoCategory', 'url'=>array('create')),
	array('label'=>'View AutoCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AutoCategory', 'url'=>array('admin')),
);
?>

<h1>Update AutoCategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>