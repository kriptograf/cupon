<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	'News'=>array('index'),
	$model->title=>array('view','id'=>$model->id_news),
	'Update',
);

?>

<h1>Новости изменение</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>