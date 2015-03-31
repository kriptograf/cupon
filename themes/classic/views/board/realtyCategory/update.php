<?php
/* @var $this RealtyCategoryController */
/* @var $model RealtyCategory */

$this->breadcrumbs=array(
	'Realty Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RealtyCategory', 'url'=>array('index')),
	array('label'=>'Create RealtyCategory', 'url'=>array('create')),
	array('label'=>'View RealtyCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RealtyCategory', 'url'=>array('admin')),
);
?>

<h1>Update RealtyCategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>