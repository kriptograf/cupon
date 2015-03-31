<?php
/* @var $this CitiesController */
/* @var $model Cities */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->name=>array('view','id'=>$model->id_city),
	'Update',
);
?>

<h1>Города - изменение</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>