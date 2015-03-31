<?php
/* @var $this NewsCompanyController */
/* @var $model NewsCompany */

$this->breadcrumbs=array(
	'News Companies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NewsCompany', 'url'=>array('index')),
	array('label'=>'Manage NewsCompany', 'url'=>array('admin')),
);
?>

<h1>Create NewsCompany</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>