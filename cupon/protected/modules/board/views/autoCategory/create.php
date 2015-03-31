<?php
/* @var $this AutoCategoryController */
/* @var $model AutoCategory */

$this->breadcrumbs=array(
	'Auto Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AutoCategory', 'url'=>array('index')),
	array('label'=>'Manage AutoCategory', 'url'=>array('admin')),
);
?>

<h1>Create AutoCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>