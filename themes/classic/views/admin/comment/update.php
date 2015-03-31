<?php
/* @var $this CommentsController */
/* @var $model Comments */

$this->breadcrumbs=array(
	'Comment'=>array('index'),
	$model->comment_id=>array('view','id'=>$model->comment_id),
	'Update',
);
?>

<h1>Отзывы о компаниях - редактирование</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>