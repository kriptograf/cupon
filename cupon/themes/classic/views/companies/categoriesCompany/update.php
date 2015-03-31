<?php
/* @var $this CategoriesCompanyController */
/* @var $model CategoriesCompany */

$this->breadcrumbs=array(
	'Categories Companies'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CategoriesCompany', 'url'=>array('index')),
	array('label'=>'Create CategoriesCompany', 'url'=>array('create')),
	array('label'=>'View CategoriesCompany', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CategoriesCompany', 'url'=>array('admin')),
);
?>

<h1>Update CategoriesCompany <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>