<?php
/* @var $this CategoriesKuponController */
/* @var $model CategoriesKupon */

/*$this->breadcrumbs=array(
	'Categories Kupons'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);  */

$this->menu=array(
	array('label'=>'List CategoriesKupon', 'url'=>array('index')),
	array('label'=>'Create CategoriesKupon', 'url'=>array('create')),
	array('label'=>'View CategoriesKupon', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CategoriesKupon', 'url'=>array('admin')),
);
?>

<h1>Категории купонов - Изменение</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>