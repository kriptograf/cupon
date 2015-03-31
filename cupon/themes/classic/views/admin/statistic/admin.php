<?php
/* @var $this StatisticController */
/* @var $model StatBanner */

$this->breadcrumbs = array(
    'Stat Banners' => array('index'),
    'Manage',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#stat-banner-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Статистика показа баннеров</h1>


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
    'id' => 'stat-banner-grid',
    'cssFile' => '/css/admin/gridview/grid.css',
    'dataProvider' => $model->search(),
    'pager' => array(
        'class' => 'LinkPager',
        'dataMenu' => $this->menu,
    ),
    'columns' => array(
        'id',
        'banner.name',
        'count',
        'date',
        'city.name',
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
