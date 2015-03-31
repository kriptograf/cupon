<?php
/* @var $this AdsImgController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ads Imgs',
);

$this->menu=array(
	array('label'=>'Create AdsImg', 'url'=>array('create')),
	array('label'=>'Manage AdsImg', 'url'=>array('admin')),
);
?>

<h1>Ads Imgs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
