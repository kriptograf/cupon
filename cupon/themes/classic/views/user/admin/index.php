<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

/*$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>
<h1>Пользователи - управление</h1>

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

<?php //echo CHtml::link(UserModule::t('Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('application.modules.admin.components.GridView', array(
	'id'=>'user-grid',
    'cssFile' => '/css/admin/gridview/grid.css',
	'dataProvider'=>$dataProvider,//$model->search(),
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
        array(
            'name'=>'identity',
            'type'=>'raw',
            'value'=>'CHtml::link(UHtml::markSearch($data,"identity"), $data->identity, array("target"=>"_blank"))',
        ),
        array(
            'name'=>'create_at',
            'value'=>'date("d.m.Y H:i",strtotime($data->create_at))',
        ),
        array(
            'name'=>'lastvisit_at',
            'value'=>'date("d.m.Y H:i",strtotime($data->lastvisit_at))',
        ),
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
            'htmlOptions' => array(
                'width' => '50px',
                'align' => 'center',
            ),
		),
        array(
            'class' => 'application.modules.admin.components.DToggleColumn',
            'name' => 'status',
            // иконка для значения 1 или true
            'onImageUrl' => Yii::app()->request->baseUrl . '/images/admin/ok.png',
            // иконка для значения 0 или false
            'offImageUrl' => Yii::app()->request->baseUrl . '/images/admin/no.png',
            // убираем генерацию ссылки по умолчанию
            //'linkUrl'=>'/admin/categoriesKupon/toggle/id/12/attribute/status',
            // запрос подтвердждения (если нужен)
            'confirmation' => 'Изменить статус пользователя?',
            // фильтр
            'filter' => array(1 => 'Опубликованные', 0 => 'Не опубликованные'),
            // alt для иконок (так как отличается от стандартного)
            'titles' => array(1 => 'Активен', 0 => 'Не активен'),
            //'actionUrl' => array('setStatus'),
            'htmlOptions' => array(
                'width' => '50px',
                'align' => 'center',
            ),
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
)); ?>
