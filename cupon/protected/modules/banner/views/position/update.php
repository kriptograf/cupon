<?php
/* @var $this PositionController */
/* @var $model PosBanner */

$this->breadcrumbs=array(
	'Pos Banners'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PosBanner', 'url'=>array('index')),
	array('label'=>'Create PosBanner', 'url'=>array('create')),
	array('label'=>'View PosBanner', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PosBanner', 'url'=>array('admin')),
);
?>

<h1>Update PosBanner <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>