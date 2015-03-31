<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'companies-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
        <?php echo $form->dropDownList($model, 'city_id', CHtml::listData(Cities::model()->findAll(), 'id_city','name'), array('empty'=>'- город -'));?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
                <?php echo $form->dropDownList($model, 'category_id', CategoriesCompany::model()->getAllCategoriesForSelect(), array('empty'=>'- Выберите рубрику -'));?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php
        //Подключаем виджет редактора
        $this->widget('application.extensions.editor.CKkceditor',array(
            //конфигурация редактора и файлового менеджера
            "model"=>$model,                //атрибут model аналогия с $form->textArea, используется имя модели в элементе <textarea>
            "attribute"=>'description',         //Название поля в БД для сохранения текста. То же самое, что $form->textArea($model,'content'
            "height"=>'200px',//Высота окна редактора
            "width"=>'100%', //Ширина окна редактора
            //Здесь главное не напутать с путями
            "filespath"=>Yii::app()->basePath."/../media/",//Путь к файлам на сервере.Такая запись будет соответствовать расположению папки media на одном уровне с index.php
            "filesurl"=>Yii::app()->baseUrl."/media/",//URL который подставляется в редактор после загрузки файла на сервер.
            //файлы сохраняются в папку media/images
        ) );
        ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
        <?php if($model->isNewRecord):?>
            <?php echo $form->labelEx($model,'logo'); ?>
            <?php echo $form->fileField($model,'logo'); ?>
            <?php echo $form->error($model,'logo'); ?>
        <?php else:?>
            <div id="img">
                <?php echo $form->labelEx($model,'logo'); ?>
                <img src="/content/companies/logo/<?php echo $model->logo;?>" width="80%">
                <br>
                <a href="#" id="change">Изменить</a>
                <?php echo $form->hiddenField($model, 'logo', array('value'=>$model->logo)); ?>
            </div>
        <?php endif;?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address'); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phones'); ?>
		<?php echo $form->textArea($model,'phones',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'phones'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link'); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>
    
    <div class="row">
                            <?php echo $form->labelEx($model,'boss'); ?>
                            <?php echo $form->textField($model,'boss'); ?>
                            <?php echo $form->error($model,'boss'); ?>
                    </div>
    
    <div class="row">
                            <?php echo $form->labelEx($model,'boss_contacts'); ?>
                            <?php echo $form->textField($model,'boss_contacts'); ?>
                            <?php echo $form->error($model,'boss_contacts'); ?>
                    </div>
    
    <div class="row">
                            <?php echo $form->labelEx($model,'boss_phones'); ?>
                            <?php echo $form->textField($model,'boss_phones'); ?>
                            <?php echo $form->error($model,'boss_phones'); ?>
                    </div>
    
    <div class="row">
                            <?php echo $form->labelEx($model,'schedule'); ?>
                            <?php echo $form->textField($model,'schedule'); ?>
                            <?php echo $form->error($model,'schedule'); ?>
                    </div>

    <div class="row">
        <?php echo $form->labelEx($gallery,'img'); ?>
        <?php
        $this->widget('CMultiFileUpload', array(
            'model'=>$gallery,
            'attribute'=>'files',
            'accept'=>'jpg|gif|png',
            'duplicate' => 'Дубликат файла!', // useful, i think
            'denied' => 'Не верный формат файла', // useful, i think
        ));
        ?>
        <div class="gal">
            <?php foreach($model->gallery as $thumb):?>
                <a title="Удалить" href="<?php echo $thumb->id;?>" id="img<?php echo $thumb->id;?>">
                <?php echo CHtml::image('/content/companies/thumbs/'.$thumb->thumb,'Превью',array('width'=>100));?>
                </a>
             <?php endforeach;?>
        </div>
        <script>
            $(document).ready(function(){
                $('.gal a').click(function(event){
                    event.preventDefault();
                    var id = $(this).attr('href');
                    var lnk = '/admin/companies/delItemGallery';
                    $.ajax({
                            url: lnk,
                            global: false,
                            type: "POST",
                            data: ({id : id}),
                            dataType: "json",
                            success: function(msg){
                                $('#img'+msg.msg).remove();
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert(textStatus);
                            }
                        }
                    );
                });

            });
        </script>
        <p class="hint">Вы можете загрузить несколько изображений</p>
    </div>

	<div class="row">
            <?php echo $form->labelEx($model,'status'); ?>
            <?php echo $form->radioButtonList($model, 'status',array('1'=>'Опубликована','0'=>'Не опубликована'));?>
            <?php echo $form->error($model,'status'); ?>
	</div>
    
        <div class="row">
            <?php echo $form->labelEx($model,'checked'); ?>
            <?php echo $form->checkBox($model, 'checked');?>
            <?php echo $form->error($model,'checked'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

    <script>
        $(document).ready(function(){
            $('#change').click(function(event){
                event.preventDefault();

                $('#img').replaceWith('<?php echo $form->labelEx($model, 'logo'); ?><?php echo $form->fileField($model, 'logo'); ?><?php echo $form->error($model, 'logo'); ?> ');
            });
        });
    </script>

</div><!-- form -->