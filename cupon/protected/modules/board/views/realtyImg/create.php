<?php
/* @var $this RealtyImgController */
/* @var $model RealtyImg */

$this->breadcrumbs=array(
	'Realty Imgs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RealtyImg', 'url'=>array('index')),
	array('label'=>'Manage RealtyImg', 'url'=>array('admin')),
);
?>

<h1>Create RealtyImg</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>