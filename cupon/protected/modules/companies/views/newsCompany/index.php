<?php
/* @var $this NewsCompanyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'News Companies',
);

$this->menu=array(
	array('label'=>'Create NewsCompany', 'url'=>array('create')),
	array('label'=>'Manage NewsCompany', 'url'=>array('admin')),
);
?>

<h1>News Companies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
