<?php
/* @var $this CategoriesCompanyController */
/* @var $model CategoriesCompany */

$this->breadcrumbs=array(
	'Categories Companies'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>Категории компаний - редактирование</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'roots'=>$roots,)); ?>