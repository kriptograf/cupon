<?php
/* @var $this AdsImgController */
/* @var $model AdsImg */

$this->breadcrumbs=array(
	'Ads Imgs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AdsImg', 'url'=>array('index')),
	array('label'=>'Manage AdsImg', 'url'=>array('admin')),
);
?>

<h1>Create AdsImg</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>