<?php
/* @var $this CommentsController */
/* @var $model Comments */

$this->breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Отзывы об акциях - редактирование</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>