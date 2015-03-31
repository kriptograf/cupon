<?php
/* @var $this AutoImgController */
/* @var $model AutoImg */

$this->breadcrumbs=array(
	'Auto Imgs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AutoImg', 'url'=>array('index')),
	array('label'=>'Manage AutoImg', 'url'=>array('admin')),
);
?>

<h1>Create AutoImg</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>