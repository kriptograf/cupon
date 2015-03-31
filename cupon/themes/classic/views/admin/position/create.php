<?php
/* @var $this PositionController */
/* @var $model PosBanner */

$this->breadcrumbs=array(
	'Pos Banners'=>array('index'),
	'Create',
);


?>

<h1>Добавление позиции баннера</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>