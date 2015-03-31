<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	'News'=>array('index'),
	'Create',
);

?>

<h1>Новости - добавление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>