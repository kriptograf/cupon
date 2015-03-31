<?php
/* @var $this StatisticController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Stat Banners',
);

$this->menu=array(
	array('label'=>'Create StatBanner', 'url'=>array('create')),
	array('label'=>'Manage StatBanner', 'url'=>array('admin')),
);
?>

<h1>Stat Banners</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
