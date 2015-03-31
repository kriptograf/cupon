<?php
/* @var $this KuponsController */
/* @var $model Kupons */

$this->breadcrumbs=array(
	'Kupons'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Kupons', 'url'=>array('index')),
	array('label'=>'Create Kupons', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#kupons-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Kupons</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'kupons-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_kupon',
		'action',
		'city_id',
		'cat_id',
		'company_id',
		'image',
		/*
		'code',
		'old_price',
		'new_price',
		'conditions',
		'details',
		'start_date',
		'end_date',
		'status',
		'position',
		'rating',
		'views',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
