<?php
/* @var $this StatisticController */
/* @var $model StatBanner */

$this->breadcrumbs=array(
	'Stat Banners'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StatBanner', 'url'=>array('index')),
	array('label'=>'Create StatBanner', 'url'=>array('create')),
	array('label'=>'View StatBanner', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StatBanner', 'url'=>array('admin')),
);
?>

<h1>Update StatBanner <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>