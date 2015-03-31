<?php
/* @var $this CategoriesKuponController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories Kupons',
);

$this->menu=array(
	array('label'=>'Create CategoriesKupon', 'url'=>array('create')),
	array('label'=>'Manage CategoriesKupon', 'url'=>array('admin')),
);
?>

<h1>Categories Kupons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
