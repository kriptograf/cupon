<?php
//Получаем из куки параметры предыдущего фильтра поиска для подстановки в форму
$post = (Yii::app()->session['realty_search']) ? Yii::app()->session['realty_search'] : '';
?>
<div class="search-filter">
    <?php echo CHtml::beginForm('/board/realty/search','post');?>

    <div id="second-filter">
        <?php
        $arr = CHtml::listData(RealtyTypes::model()->findAll(),'id','title')
        //$arr = array('1'=>'Купить','2'=>'Продать');
        ?>
        <?php echo CHtml::label('Я хочу','');?>
        <?php echo CHtml::dropDownList('type', ($post['type'])?$post['type']:'1' , $arr);?>

        <?php echo CHtml::label('Категория','');?>
        <?php //echo CHtml::dropDownList('category','',CHtml::listData(BoardCategory::model()->findAll(),'id','name'));?>
        <?php echo CHtml::dropDownList('category', ($post['category'])?$post['category']:'' ,RealtyCategory::getCategoriesForSelect());?>

        <?php echo CHtml::label('Город','');?>
        <?php echo CHtml::dropDownList('city',($post['city'])?$post['city']:'', CHtml::listData(Cities::model()->findAll(),'id_city','name'),array('id'=>'city-search'));?>
    </div>

    <div id="thrid-filter">
        <?php echo CHtml::label('Не показывать без цены','');?>
        <?php echo CHtml::checkBox('notprice',(isset($post['notprice']))?true:false);?>
        <?php echo CHtml::submitButton('Найти',array('id'=>'btn-submit'))?>
    </div>

    <?php echo CHtml::endForm();?>
</div>