<?php
/* @var $this PositionController */
/* @var $model PosBanner */

$this->breadcrumbs=array(
	'Pos Banners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PosBanner', 'url'=>array('index')),
	array('label'=>'Manage PosBanner', 'url'=>array('admin')),
);
?>

<h1>Create PosBanner</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>