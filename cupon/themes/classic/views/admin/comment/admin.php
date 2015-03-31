<?php
$this->breadcrumbs=array(
	Yii::t('CommentsModule.msg', 'Comments')=>array('index'),
	Yii::t('CommentsModule.msg', 'Manage'),
);
?>

<h1><?php echo Yii::t('CommentsModule.msg', 'Manage Comments');?></h1>

<?php
$this->menu=array(
    //array('label'=>'+ Добавить', 'url'=>array('create'), 'linkOptions'=>array('class'=>'add')),
    array('label'=>'х Удалить', 'url'=>'#', 'linkOptions'=>array('class'=>'add', 'id'=>'group-operation-submit-top','onclick'=>'groupOperation();return false;')),
);
$this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'operations'),
));
?>

<?php $this->widget('application.modules.admin.components.GridView', array(
	'id'=>'comment-grid',
    'cssFile'=>'/css/admin/gridview/grid.css',
    'summaryText'=>'',
    'groupActions'=>false,
	'dataProvider'=>$model->search(),
    'pager'=>array(
        'class'=>'LinkPager',
        //'dataMenu'=>$this->menu,
    ),
	'columns'=>array(
                /*array(
                    'name'=>'owner_name',
                    'htmlOptions'=>array('width'=>50),
                ),*/
                array(
                    'header'=>'Компания',
                    'name'=>'owner_id',
                    'value'=>'$data->company->title',
                    'htmlOptions'=>array('width'=>50),
                ),
                array(
                    'header'=>Yii::t('CommentsModule.msg', 'User Name'),
                    'value'=>'$data->userName',
                    'htmlOptions'=>array('width'=>80),
                ),
                /*array(
                    'header'=>Yii::t('CommentsModule.msg', 'Link'),
                    'value'=>'CHtml::link(CHtml::link(Yii::t("CommentsModule.msg", "Link"), $data->pageUrl, array("target"=>"_blank")))',
                    'type'=>'raw',
                    'htmlOptions'=>array('width'=>50),
		        ),*/
		        'comment_text',
                array(
                    'name'=>'create_time',
                    //'type'=>'datetime',
                    'value'=>'date("d.m.Y",$data->create_time)',
                    'htmlOptions'=>array('width'=>70),
                    'filter'=>false,
                ),
		        /*'update_time',*/
                array(
                    'class'=>'DToggleColumn',
                    'name' => 'status',
                    // иконка для значения 1 или true
                    'onImageUrl' => Yii::app()->request->baseUrl . '/images/admin/ok.png',
                    // иконка для значения 0 или false
                    'offImageUrl' => Yii::app()->request->baseUrl . '/images/admin/no.png',
                    // убираем генерацию ссылки по умолчанию
                    'linkUrl'=>'Yii::app()->urlManager->createUrl(CommentsModule::APPROVE_ACTION_ROUTE, array("id"=>$data->comment_id))',
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
                    'name'=>'status',
                    //'value'=>'$data->textStatus',
                    'value'=>'$data->status',
                    'htmlOptions'=>array('width'=>50),
                    'filter'=>Comment::model()->getStatuses(),
                ),*/
		        /*array(
			        'class'=>'CButtonColumn',
                    'deleteButtonImageUrl'=>false,
                    'buttons'=>array(
                            'approve' => array(
                                'label'=>Yii::t('CommentsModule.msg', 'Approve'),
                                'url'=>'Yii::app()->urlManager->createUrl(CommentsModule::APPROVE_ACTION_ROUTE, array("id"=>$data->comment_id))',
                                'options'=>array('style'=>'margin-right: 5px;'),
                                'click'=>'function(){
                                    if(confirm("'.Yii::t('CommentsModule.msg', 'Approve this comment?').'"))
                                    {
                                        $.post($(this).attr("href")).success(function(data){
                                            data = $.parseJSON(data);
                                            if(data["code"] === "success")
                                            {
                                                $.fn.yiiGridView.update("comment-grid");
                                            }
                                        });
                                    }
                                    return false;
                                }',
				                'visible'=>'$data->status == Comment::STATUS_NOT_APPROVED',
                            ),
                        ),
                        'template'=>'{approve}{delete}',
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
