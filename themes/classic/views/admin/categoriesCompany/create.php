<?php
/* @var $this CategoriesCompanyController */
/* @var $model CategoriesCompany */

$this->breadcrumbs=array(
	'Categories Companies'=>array('index'),
	'Create',
);

?>

<h1>Категории компаний - добавление подкатегории</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'roots'=>$roots)); ?>