<?php
/* @var $this PositionController */
/* @var $model PosBanner */

$this->breadcrumbs = array(
    'Pos Banners' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List PosBanner', 'url' => array('index')),
    array('label' => 'Create PosBanner', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pos-banner-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Баннеры - позиции на странице</h1>

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
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('application.modules.admin.components.GridView', array(
    'id' => 'pos-banner-grid',
    'cssFile' => '/css/admin/gridview/grid.css',
    'dataProvider' => $model->search(),
    'pager' => array(
        'class' => 'LinkPager',
        'dataMenu' => $this->menu,
    ),
    'columns' => array(
        'id',
        'pos',
        array(
            'class' => 'phaEditColumn',
            'name' => 'title',
            'actionUrl' => array('setTitle'),
        ),
        array(
            'class' => 'phaEditColumn',
            'name' => 'description',
            'actionUrl' => array('setDesc'),
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => 'Изменить',
            'template' => '{update}',
            'buttons' => array
                (
                'update' => array
                    (
                    'label' => 'Редактировать',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/admin/edit.png',
                //'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
                ),
            ),
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => 'Удалить',
            'template' => '{delete}',
            'buttons' => array
                (
                'delete' => array
                    (
                    'label' => 'Удалить',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/admin/delete.png',
                //'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
));
?>
