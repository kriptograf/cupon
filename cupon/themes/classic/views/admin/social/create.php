<?php
/* @var $this SocialController */
/* @var $model Social */

$this->breadcrumbs=array(
	'Socials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Social', 'url'=>array('index')),
	array('label'=>'Manage Social', 'url'=>array('admin')),
);
?>

<h1>Кнопки "Мы в соцсетях" - добавление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>