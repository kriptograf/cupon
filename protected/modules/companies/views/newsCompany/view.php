<?php
/* @var $this NewsCompanyController */
/* @var $model NewsCompany */

$this->breadcrumbs=array(
	'News Companies'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List NewsCompany', 'url'=>array('index')),
	array('label'=>'Create NewsCompany', 'url'=>array('create')),
	array('label'=>'Update NewsCompany', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NewsCompany', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NewsCompany', 'url'=>array('admin')),
);
?>

<h1>View NewsCompany #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company_id',
		'date',
		'title',
		'intro',
		'text',
		'status',
	),
)); ?>
