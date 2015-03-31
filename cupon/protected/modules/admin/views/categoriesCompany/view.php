<?php
/* @var $this CategoriesCompanyController */
/* @var $model CategoriesCompany */

$this->breadcrumbs=array(
	'Categories Companies'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CategoriesCompany', 'url'=>array('index')),
	array('label'=>'Create CategoriesCompany', 'url'=>array('create')),
	array('label'=>'Update CategoriesCompany', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CategoriesCompany', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoriesCompany', 'url'=>array('admin')),
);
?>

<h1>View CategoriesCompany #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'sort',
	),
)); ?>
