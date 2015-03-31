<?php
/* @var $this PageController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Статические страницы - редактирование</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>