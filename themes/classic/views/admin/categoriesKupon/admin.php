<?php
/* @var $this CategoriesKuponController */
/* @var $model CategoriesKupon */

$this->breadcrumbs=array(
	'Categories Kupons'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'+ Добавить', 'url'=>array('create'), 'linkOptions'=>array('class'=>'add')),
    array('label'=>'х Удалить', 'url'=>'#', 'linkOptions'=>array('class'=>'add', 'id'=>'group-operation-submit-top','onclick'=>'groupOperation();return false;')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#categories-kupon-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление категориями купонов</h1>

<?php
$this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'operations'),
));
/*echo CHtml::button('x Удалить', array(

    'id'=>'group-operation-submit-top',

    'onclick'=>'groupOperation()',

)); */
 //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$this->widget('application.modules.admin.components.GridView', array(
    'id'=>'categories-kupon-grid',
    'cssFile'=>'/css/admin/gridview/grid.css',
    'summaryText'=>'',
    'dataProvider'=>$model->search(),
    'groupActions'=>array(
        'groupDecline'=>'Delete',
    ),
    'pager'=>array(
        'class'=>'LinkPager',
        'dataMenu'=>$this->menu,
    ),
    //'filter'=>$model,
    'columns'=>array(
        /*array(
            'class'=>'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('class' => 'classname'),
        ), */
        array(
            'name'=>'id',
            'htmlOptions'=>array(
                'width'=>'50px',
                'align'=>'center',
            ),
        ),
        array(
            'class' => 'phaEditColumn',
            'name' => 'name',
            'actionUrl' => array('setName'),
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
            'name'=>'pos',
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
));

?>
