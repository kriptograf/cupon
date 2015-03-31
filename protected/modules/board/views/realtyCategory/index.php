<?php
/* @var $this RealtyCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Realty Categories',
);

$this->menu=array(
	array('label'=>'Create RealtyCategory', 'url'=>array('create')),
	array('label'=>'Manage RealtyCategory', 'url'=>array('admin')),
);
?>

<h1>Realty Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
