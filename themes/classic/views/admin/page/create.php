<?php
/* @var $this PageController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	'Create',
);
?>

<h1>Статические страницы - добавление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>