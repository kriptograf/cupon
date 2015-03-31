<?php
/* @var $this AutoTypesController */
/* @var $model AutoTypes */

$this->breadcrumbs=array(
	'Auto Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AutoTypes', 'url'=>array('index')),
	array('label'=>'Create AutoTypes', 'url'=>array('create')),
	array('label'=>'View AutoTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AutoTypes', 'url'=>array('admin')),
);
?>

<h1>Update AutoTypes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>