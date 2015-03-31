<?php
/* @var $this CategoriesCompanyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories Companies',
);

$this->menu=array(
	array('label'=>'Create CategoriesCompany', 'url'=>array('create')),
	array('label'=>'Manage CategoriesCompany', 'url'=>array('admin')),
);
?>

<h1>Categories Companies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
