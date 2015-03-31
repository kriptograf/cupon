<?php
/* @var $this SettingsController */
/* @var $model Settings */

$this->breadcrumbs=array(
	'Settings'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#settings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Настройки сайта</h1>

<?php
$this->menu = array(
    array('label' => '+ Добавить', 'url' => array('create'), 'linkOptions' => array('class' => 'add')),
    array('label' => 'х Удалить', 'url' => '#', 'linkOptions' => array('class' => 'add', 'id' => 'group-operation-submit-top', 'onclick' => 'groupOperation();return false;')),
);
$this->widget('zii.widgets.CMenu', array(
    'items' => $this->menu,
    'htmlOptions' => array('class' => 'operations'),
));
?>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.modules.admin.components.GridView', array(
	'id'=>'settings-grid',
    'cssFile' => '/css/admin/gridview/grid.css',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		'logo',
		'title',
		'version',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
