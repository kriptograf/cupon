<?php
/* @var $this KuponsController */
/* @var $model Kupons */

/*$this->breadcrumbs=array(
	'Kupons'=>array('index'),
	'Manage',
);*/



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

<h1>Купоны</h1>

<?php
$this->menu=array(
    array('label'=>'+ Добавить', 'url'=>array('create'), 'linkOptions'=>array('class'=>'add')),
    array('label'=>'х Удалить', 'url'=>'#', 'linkOptions'=>array('class'=>'add', 'id'=>'group-operation-submit-top','onclick'=>'groupOperation();return false;')),
);
$this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'operations'),
));
?>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.modules.admin.components.GridView', array(
	'id'=>'kupons-grid',
    'cssFile'=>'/css/admin/gridview/grid.css',
    'summaryText'=>'',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'pager'=>array(
        'class'=>'LinkPager',
        'dataMenu'=>$this->menu,
    ),
	'columns'=>array(
		'id_kupon',
        array(
            'class' => 'phaEditColumn',
            'name' => 'action',
            'actionUrl' => array('setAction'),
            'modelId'=>'id_kupon',
        ),
        array(
            'class' => 'phaEditColumn',
            'name' => 'code',
            'actionUrl' => array('setCode'),
            'modelId'=>'id_kupon',
        ),
        array(
            'name'=>'company_id',
            'value'=>'$data->company->title',
            'sortable'=>true,
        ),
        array(
            'name'=>'cat_id',
            'value'=>'$data->cat->name',
            'sortable'=>true,
        ),
		'old_price',
		'new_price',
        array(
            'name'=>'tax',
            'htmlOptions'=>array(
                'align'=>'center',
            ),
        ),
        array(
           'name'=>'start_date',
            'value'=>'date("d.m.Y",strtotime($data->start_date))'
        ),
        array(
            'name'=>'rating',
            'htmlOptions'=>array(
                'align'=>'center',
            ),
        ),
        array(
            'name'=>'views',
            'htmlOptions'=>array(
                'align'=>'center',
            ),
        ),
        array(
            'class'=>'DToggleColumn',
            'name' => 'status',
            // иконка для значения 1 или true
            'onImageUrl' => Yii::app()->request->baseUrl . '/images/admin/ok.png',
            // иконка для значения 0 или false
            'offImageUrl' => Yii::app()->request->baseUrl . '/images/admin/no.png',
            // убираем генерацию ссылки по умолчанию
            //'linkUrl'=>'/admin/categoriesKupon/toggle/id/12/attribute/status',
            // запрос подтвердждения (если нужен)
            'confirmation'=>'Изменить статус публикации?',
            // фильтр
            'filter'=>array(1=>'Опубликованные', 0=>'Не опубликованные'),
            // alt для иконок (так как отличается от стандартного)
            'titles'=>array(1=>'Опубликовано', 0=>'Не опубликовано'),
            //'actionUrl' => array('setStatus'),
            'htmlOptions'=>array(
                'width'=>'50px',
                'align'=>'center',
            ),
        ),
        /*array(
            'header'=>'Позиция',
            'name'=>'position',
            'type'=>'html',
            'value'=>'CHtml::link(CHtml::image("/images/admin/pos.png"),"#")',
            'htmlOptions'=>array(
                'width'=>'70px',
                'align'=>'center',
            ),
        ),*/
        array(
            'class'=>'CButtonColumn',
            'header'=>'Изменить',
            'template'=>'{update}',
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=>'Редактировать',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/edit.png',
                    //'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
                ),
            ),
        ),
        array(
            'class'=>'CButtonColumn',
            'header'=>'Удалить',
            'template'=>'{delete}',
            'buttons'=>array
            (
                'delete' => array
                (
                    'label'=>'Удалить',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/delete.png',
                    //'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
                ),
            ),
        ),
	),
)); ?>
