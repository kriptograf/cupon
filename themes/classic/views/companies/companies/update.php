<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->breadcrumbs=array(
	$model->category->name=>array('/category/'.$model->category->id),
	$model->title=>array('view','id'=>$model->id),
	'Редактирование',
);
?>

<?php echo $this->renderPartial('_edit', array(
    'model'=>$model,
    'gallery' => $gallery,
    'news' => $news,
)); ?>