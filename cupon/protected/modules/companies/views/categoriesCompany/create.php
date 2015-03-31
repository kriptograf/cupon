<?php
/* @var $this CategoriesCompanyController */
/* @var $model CategoriesCompany */

$this->breadcrumbs=array(
	'Categories Companies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CategoriesCompany', 'url'=>array('index')),
	array('label'=>'Manage CategoriesCompany', 'url'=>array('admin')),
);
?>

<h1>Create CategoriesCompany</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>