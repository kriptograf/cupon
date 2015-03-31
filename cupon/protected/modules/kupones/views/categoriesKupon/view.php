<?php
/* @var $this CategoriesKuponController */
/* @var $model CategoriesKupon */

$this->breadcrumbs=array(
	'Categories Kupons'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CategoriesKupon', 'url'=>array('index')),
	array('label'=>'Create CategoriesKupon', 'url'=>array('create')),
	array('label'=>'Update CategoriesKupon', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CategoriesKupon', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoriesKupon', 'url'=>array('admin')),
);
?>

<h1>View CategoriesKupon #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
	),
)); ?>
