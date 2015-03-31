<?php
/* @var $this RealtyImgController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Realty Imgs',
);

$this->menu=array(
	array('label'=>'Create RealtyImg', 'url'=>array('create')),
	array('label'=>'Manage RealtyImg', 'url'=>array('admin')),
);
?>

<h1>Realty Imgs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
