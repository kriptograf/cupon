<?php
/* @var $this NewsCompanyController */
/* @var $model NewsCompany */

$this->breadcrumbs=array(
	'News Companies'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NewsCompany', 'url'=>array('index')),
	array('label'=>'Create NewsCompany', 'url'=>array('create')),
	array('label'=>'View NewsCompany', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NewsCompany', 'url'=>array('admin')),
);
?>

<h1>Update NewsCompany <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>