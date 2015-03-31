<?php
/* @var $this AutoTypesController */
/* @var $model AutoTypes */

$this->breadcrumbs=array(
	'Auto Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AutoTypes', 'url'=>array('index')),
	array('label'=>'Manage AutoTypes', 'url'=>array('admin')),
);
?>

<h1>Create AutoTypes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>