<?php
/* @var $this RealtyController */
/* @var $model Realty */

$this->breadcrumbs=array(
	'Realties'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Realty', 'url'=>array('index')),
	array('label'=>'Create Realty', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#realty-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Realties</h1>

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
	'id'=>'realty-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'category_id',
		'city_id',
		'user_id',
		'type_id',
		'title',
		/*
		'area',
		'rooms',
		'details',
		'price',
		'author',
		'email',
		'phone',
		'address',
		'date_pub',
		'date_end',
		'checked',
		'views',
		'status',
		'x',
		'y',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
