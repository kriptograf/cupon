<?php
/* @var $this CategoriesKuponController */
/* @var $model CategoriesKupon */

/*$this->breadcrumbs=array(
	'Categories Kupons'=>array('index'),
	'Create',
); */

$this->menu=array(
	array('label'=>'List CategoriesKupon', 'url'=>array('index')),
	array('label'=>'Manage CategoriesKupon', 'url'=>array('admin')),
);
?>

<h1>Категории купонов - Добавление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>