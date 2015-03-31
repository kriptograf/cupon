<?php
/* @var $this StatisticController */
/* @var $model StatBanner */

$this->breadcrumbs=array(
	'Stat Banners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StatBanner', 'url'=>array('index')),
	array('label'=>'Manage StatBanner', 'url'=>array('admin')),
);
?>

<h1>Create StatBanner</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>