<?php
/* @var $this CategoryTypesController */
/* @var $model CategoryTypes */

$this->breadcrumbs=array(
	'Category Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CategoryTypes', 'url'=>array('index')),
	array('label'=>'Manage CategoryTypes', 'url'=>array('admin')),
);
?>

<h1>Create CategoryTypes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>