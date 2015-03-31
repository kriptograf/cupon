<?php
/* @var $this CategoriesCompanyController */
/* @var $model CategoriesCompany */

$this->breadcrumbs=array(
	'Categories Companies'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#categories-company-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Категории компаний - управление</h1>

<?php
$this->menu=array(
array('label'=>'+ Добавить категорию', 'url'=>array('createRoot'), 'linkOptions'=>array('class'=>'add')),
array('label'=>'+ Добавить подкатегорию', 'url'=>array('createChild'), 'linkOptions'=>array('class'=>'add')),
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
	'id'=>'categories-company-grid',
    'cssFile'=>'/css/admin/gridview/grid.css',
    'summaryText'=>'',
    'ajaxUpdate'=>false,
	//'dataProvider'=>$model->search(),
    'dataProvider'=>$tree,
    'sub'=>true,
    'pager'=>array(
            'class'=>'LinkPager',
            'dataMenu'=>$this->menu,

    ),
	'columns'=>array(
		'id',
                array(
                    'class' => 'phaEditColumn',
                    'header'=>'Название категории',
                    'name' => 'name',
                    'type' => 'html',
                    'value'=>'($data["parent_id"])?$data["name"]:"<strong>".$data["name"]."</strong>"',
                    'actionUrl' => array('setName'),
                ),
//        array(
//            'header'=>'Позиция',
//            'name'=>'sort',
//            'type'=>'html',
//            'value'=>'CHtml::link(CHtml::image("/images/admin/pos.png"),"#")',
//            'htmlOptions'=>array(
//                'width'=>'70px',
//                'align'=>'center',
//            ),
//        ),

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
                        'url'=>'Yii::app()->createUrl("admin/categoriesCompany/update/", array("id"=>$data["id"],"returnPage"=>Yii::app()->request->getQuery("id_page", 1)))',
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
                        'url'=>'Yii::app()->createUrl("admin/categoriesCompany/delete/", array("id"=>$data["id"]))',
                    ),
                ),
            ),
	),
)); ?>
