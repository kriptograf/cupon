<?php
/* @var $this RealtyImgController */
/* @var $model RealtyImg */

$this->breadcrumbs=array(
	'Realty Imgs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RealtyImg', 'url'=>array('index')),
	array('label'=>'Create RealtyImg', 'url'=>array('create')),
	array('label'=>'View RealtyImg', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RealtyImg', 'url'=>array('admin')),
);
?>

<h1>Update RealtyImg <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>