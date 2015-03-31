<?php
//Получаем из куки параметры предыдущего фильтра поиска для подстановки в форму
$post = (Yii::app()->session['ads_search']) ? Yii::app()->session['ads_search'] : '';
?>
<div class="search-filter">
    <?php echo CHtml::beginForm('/board/ads/search','post');?>
    <div id="first-filter">
        <?php echo CHtml::label('Введите слово или фразу','');?>
        <?php echo CHtml::textField('query',($post['query'])?$post['query']:'');?>
    </div>
    <div id="second-filter">
        <?php
        //CHtml::listData(Types::model()->findAll(),'id','title')
        $arr = array('1'=>'Купить','2'=>'Продать');
        ?>
        <?php echo CHtml::label('Я хочу','');?>
        <?php echo CHtml::dropDownList('type', ($post['type'])?$post['type']:'1' , $arr);?>

        <?php echo CHtml::label('Категория','');?>
        <?php //echo CHtml::dropDownList('category','',CHtml::listData(BoardCategory::model()->findAll(),'id','name'));?>
        <?php echo CHtml::dropDownList('category', ($post['category'])?$post['category']:'' ,BoardCategory::getCategoriesForSelect());?>

        <?php echo CHtml::label('Дата подачи','');?>
        <?php echo CHtml::dropDownList('date_range',($post['date_range'])?$post['date_range']:'', array('all'=>'За все время','week'=>'За неделю'));?>
    </div>
    <div id="thrid-filter">
        <?php echo CHtml::label('Цена от','');?>
        <?php echo CHtml::textField('minprice',($post['minprice'])?$post['minprice']:'');?>
        <?php echo CHtml::label('до','');?>
        <?php echo CHtml::textField('maxprice',($post['maxprice'])?$post['maxprice']:'');?>
        <?php echo CHtml::label('Не показывать без цены','');?>
        <?php echo CHtml::checkBox('notprice',(isset($post['notprice']))?true:false);?>
        <?php echo CHtml::submitButton('Найти',array('id'=>'btn-submit'))?>
    </div>
    <?php echo CHtml::endForm();?>
</div>