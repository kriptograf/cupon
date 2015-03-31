<?php
/* @var $this AutoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Autos',
);

$this->menu=array(
	array('label'=>'Create Auto', 'url'=>array('create')),
	array('label'=>'Manage Auto', 'url'=>array('admin')),
);
?>

<h1>Autos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
