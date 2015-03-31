<?php
/* @var $this AutoImgController */
/* @var $model AutoImg */

$this->breadcrumbs=array(
	'Auto Imgs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AutoImg', 'url'=>array('index')),
	array('label'=>'Create AutoImg', 'url'=>array('create')),
	array('label'=>'View AutoImg', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AutoImg', 'url'=>array('admin')),
);
?>

<h1>Update AutoImg <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>