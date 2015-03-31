<?php
/* @var $this CategoriesCompanyController */
/* @var $model CategoriesCompany */

$this->breadcrumbs=array(
	'Categories Companies'=>array('index'),
	'Create',
);

?>

<h1>Категории компаний - добавление категории</h1>

<?php echo $this->renderPartial('_formRoot', array('model'=>$model, 'roots'=>$roots)); ?>