<?php
/* @var $this AutoController */
/* @var $model Auto */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCssFile('/css/board/auto_form.css');
Yii::app()->clientScript->registerScriptFile('/js/charCount.js',  CClientScript::POS_HEAD);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'auto-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>



	<?php echo $form->errorSummary($model); ?>

	<div class="row">
        <?php echo $form->labelEx($model,'type_id'); ?>
        <?php echo $form->dropDownList($model,'type_id',CHtml::listData($types,'id','title'));?>
        <?php echo $form->error($model,'type_id'); ?>

		<?php echo $form->labelEx($model,'category_id'); ?>
        <?php echo $form->dropDownList($model,'category_id',CHtml::listData($category,'id','name'));?>
		<?php echo $form->error($model,'category_id'); ?>

        <?php echo $form->labelEx($model,'city_id'); ?>
        <?php echo $form->dropDownList($model,'city_id',CHtml::listData($city,'id_city','name'));?>
        <?php echo $form->error($model,'city_id'); ?>
	</div>


	<div class="row">
        <?php echo $form->hiddenField($model,'user_id', array('value'=>Yii::app()->user->id)); ?>
	</div>

	<div class="row">

	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'title'); ?>
		<?php //echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mark'); ?>
		<?php echo $form->textField($model,'mark',array('size'=>15,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'mark'); ?>

		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>15,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'model'); ?>

		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model,'year',array('size'=>15)); ?>
		<?php echo $form->error($model,'year'); ?>

		<?php echo $form->labelEx($model,'milage'); ?>
		<?php echo $form->textField($model,'milage',array('size'=>15)); ?>
		<?php echo $form->error($model,'milage'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'price'); ?>
        <?php echo $form->textField($model,'price',array('size'=>12,'maxlength'=>12)); ?>
        <?php echo $form->error($model,'price'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'details'); ?>
		<?php echo $form->textArea($model,'details',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'details'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>400)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
        <?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>555)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

    <h3>Фото <span class="count-foto">Загруженные фотографии<span class="foto-grey">(<span id="count">0</span>)</span></span></h3>
    <div class="limit">Фото не более 4 шт.</div>

    <div class="row">
        <?php
        $this->widget('xupload.XUpload', array(
            'url' => Yii::app()->createUrl("/board/auto/upload"),
            'model' => $photos,
            'attribute' => 'file',
            'multiple' => true,
            'autoUpload'=>true,
            'formView'=>'form2',
            'uploadView'=>'upload2',
            'downloadView'=>'download2',
            'options' => array(
                'maxNumberOfFiles' => 4, // максимум 1 файл
                'maxFileSize' => 2000000 /* 20 Mb*/
            ),
            'htmlOptions' => array(
                'id'=>'auto-form',
            ),
        ));
        ?>
        <?php echo $form->error($photos,'file'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::button('Предпросмотр',array('class'=>'pre-view'))?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Опубликовать' : 'Сохранить', array('class'=>'btn btn-primary start')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $(document).ready(function(){
        $('.form').ajaxStart(function(){
            $('.fileinput-button').addClass('loading');
        });
        $('.form').ajaxStop(function(){
            $('.fileinput-button').removeClass('loading');
            var count = $('.template-download').size();
            $('#count').text(count);
        });
        $("#Auto_title").charCount({
            allowed: 150,
            warning: 20,
            counterText: 'oсталось: '
        });
        $("#Auto_details").charCount({
            allowed: 1000,
            warning: 20,
            counterText: 'oсталось: '
        });

        $('#Auto_category_id').change(function(){
            var cat = $('#Auto_category_id').val();
            $.post('/board/auto/flagType',{'cat':cat},function(data){
                alert(data)
            });
        });
        //Предпрлсмотр
        $('.pre-view').click(function(){
            var title = $('#Auto_title').val();
            var price = $('#Auto_price').val();
            var details = $('#Auto_details').val();
            var author = $('#Auto_author').val();
            var email = $('#Auto_email').val();
            var phone = $('#Auto_phone').val();
            var address = $('#Auto_address').val();

            /*if(title == '')
             {
             alert('Заполните поле "Заголовок"')
             }*/
            if(price =='')
            {
                alert('Заполните поле "Цена"')
            }
            else if(details =='')
            {
                alert('Заполните поле "Подробно"')
            }
            else if(author =='')
            {
                alert('Заполните поле "Контактное лицо"')
            }
            else if(email =='')
            {
                alert('Заполните поле "Email"')
            }
            else if(phone =='')
            {
                alert('Заполните поле "Телефон"')
            }
            else if(address =='')
            {
                alert('Заполните поле "Адрес"')
            }
            else
            {
                var prev = window.open('/board/auto/preview');
            }

        });

    });
</script>