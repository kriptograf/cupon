<?php
/* @var $this CategoryTypesController */
/* @var $model CategoryTypes */

$this->breadcrumbs=array(
	'Category Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CategoryTypes', 'url'=>array('index')),
	array('label'=>'Create CategoryTypes', 'url'=>array('create')),
	array('label'=>'View CategoryTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CategoryTypes', 'url'=>array('admin')),
);
?>

<h1>Update CategoryTypes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>