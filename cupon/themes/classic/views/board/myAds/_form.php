<?php
/* @var $this AdsController */
/* @var $model Ads */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerCssFile('/css/board/ads_form.css');
Yii::app()->clientScript->registerScriptFile('/js/charCount.js',  CClientScript::POS_HEAD);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ads-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <h3>Параметры</h3>

	<div class="row">
        <?php echo $form->labelEx($model,'type_id', array('class'=>'inline')); ?>
        <?php echo $form->dropDownList($model,'type_id',CHtml::listData($types,'id','title'));?>
        <?php echo $form->error($model,'type_id'); ?>

		<?php echo $form->labelEx($model,'category_id',array('class'=>'inline')); ?>
        <?php echo $form->dropDownList($model,'category_id',CHtml::listData($category,'id','name'));?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'price',array('class'=>'inline')); ?>&nbsp;
        <?php echo $form->textField($model,'price',array('size'=>8,'maxlength'=>8)); ?> руб.
        <?php echo $form->error($model,'price'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id',array('class'=>'inline')); ?>
        <?php echo $form->dropDownList($model,'city_id',CHtml::listData($city,'id_city','name'));?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'user_id', array('value'=>Yii::app()->user->id)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'details'); ?>
		<?php echo $form->textArea($model,'details',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'details'); ?>
	</div>


    <h3>Продавец</h3>

	<div class="row">
		<?php echo $form->labelEx($model,'author',array('class'=>'inline')); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email',array('class'=>'inline')); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>400)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone',array('class'=>'inline')); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>

        <?php echo $form->labelEx($model,'address',array('class'=>'inline')); ?>
        <?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'address'); ?>
	</div>

	<h3>Фото <span class="count-foto">Загруженные фотографии<span class="foto-grey">(<span id="count">0</span>)</span></span></h3>
    <div class="limit">Фото не более 4 шт.</div>

	<div class="row">
        <?php
        $this->widget('xupload.XUpload', array(
            'url' => Yii::app()->createUrl("/board/ads/upload"),
            'model' => $photos,
            'attribute' => 'file',
            'multiple' => true,
            'autoUpload'=>true,
            'formView'=>'form2',
            'uploadView'=>'upload2',
            'downloadView'=>'download2',
            'options' => array(
                'maxNumberOfFiles' => 4, // максимум 4 файлa
                'maxFileSize' => 2000000 /* 2 Mb*/
            ),
            'htmlOptions' => array(
                'id'=>'ads-form',
            ),
        ));
        ?>
        <?php if($images):?>
        <div class="table table-striped">
            <ul id="ulfiles" class="files" data-target="#modal-gallery" data-toggle="modal-gallery">
                <?php foreach($images as $image):?>
                <li class="template-download fade in" style="height: 125px;">
                    <div class="preview">
                        <span class="delete">
                            <button class="btn btn-danger" title="Удалить" data-url="/board/myAds/delImg/id/<?php echo $image->id;?>" data-type="POST">
                                <img src="<?php echo $image->thumb;?>">
                            </button>
                        </span>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
            <script>
                $(document).ready(function(){
                    var size = $("#ulfiles > li").length;
                    if(size >= 4)
                    {
                        $('.fileupload-buttonbar').find('.fileinput-button input')
                            .prop('disabled', true)
                            .parent().addClass('disabled');
                    }
                    $('.row').ajaxStop(function(event,request, settings){
                        size = $("#ulfiles > li").length;
                        if(size >= 4)
                        {
                            $('.fileupload-buttonbar').find('.fileinput-button input')
                                .prop('disabled', true)
                                .parent().addClass('disabled');
                        }
                    });

                });
            </script>
        <?php endif;?>
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
        $("#Ads_title").charCount({
            allowed: 150,
            warning: 20,
            counterText: 'oсталось: '
        });
        $("#Ads_details").charCount({
            allowed: 1000,
            warning: 20,
            counterText: 'oсталось: '
        });
        //Предпрлсмотр
        $('.pre-view').click(function(){
            var title = $('#Ads_title').val();
            var price = $('#Ads_price').val();
            var details = $('#Ads_details').val();
            var author = $('#Ads_author').val();
            var email = $('#Ads_email').val();
            var phone = $('#Ads_phone').val();
            var address = $('#Ads_address').val();

            if(title == '')
            {
                alert('Заполните поле "Заголовок"')
            }
            else if(price =='')
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
            else
            {
                var prev = window.open('/board/ads/preview');
            }

        });

    });
</script>