<?php
/* @var $this ActivatedController */
/* @var $model KuponsActive */

$this->breadcrumbs=array(
	'Kupons Actives'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List KuponsActive', 'url'=>array('index')),
	array('label'=>'Manage KuponsActive', 'url'=>array('admin')),
);
?>

<h1>Create KuponsActive</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>