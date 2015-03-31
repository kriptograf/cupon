<?php
/* @var $this CommentsController */
/* @var $dataProvider CActiveDataProvider */
?>
<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'list-comment',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'summaryText'=>false,
    'emptyText'=>Yii::app()->user->isGuest?'Отзывов пока нет':'Ваш отзыв будет первым!'
)); ?>
