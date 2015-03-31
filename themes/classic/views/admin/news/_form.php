<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_city'); ?>
        <?php echo $form->dropDownList($model,'id_city', CHtml::listData(Cities::model()->findAll(), 'id_city','name'), array('empty'=>'- город -'))?>
		<?php echo $form->error($model,'id_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
        <?php
        //Подключаем виджет редактора
        $this->widget('application.extensions.editor.CKkceditor',array(
            //конфигурация редактора и файлового менеджера
            "model"=>$model,                //атрибут model аналогия с $form->textArea, используется имя модели в элементе <textarea>
            "attribute"=>'content',         //Название поля в БД для сохранения текста. То же самое, что $form->textArea($model,'content'
            "height"=>'200px',//Высота окна редактора
            "width"=>'100%', //Ширина окна редактора
            //Здесь главное не напутать с путями
            "filespath"=>Yii::app()->basePath."/../media/",//Путь к файлам на сервере.Такая запись будет соответствовать расположению папки media на одном уровне с index.php
            "filesurl"=>Yii::app()->baseUrl."/media/",//URL который подставляется в редактор после загрузки файла на сервер.
            //файлы сохраняются в папку media/images
        ) );
        ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model, 'status',array('1'=>'Опубликована','0'=>'Не опубликована'));?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
        <?php if($model->isNewRecord):?>
            <?php echo $form->labelEx($model,'image'); ?>
            <?php echo $form->fileField($model,'image');?>
            <?php echo $form->error($model,'image'); ?>
        <?php else:?>
            <div id="img">
                <img src="/content/news/<?php echo $model->image;?>" width="80%">
                <br>
                <a href="#" id="change">Изменить</a>
                <?php echo $form->hiddenField($model, 'image', array('value'=>$model->image)); ?>
            </div>
        <?php endif;?>
	</div>

    <div class="row">
        <?php //echo $form->labelEx($model,'IsFeatured'); ?>
        <?php //echo $form->textField($model,'IsFeatured'); ?>
    </div>


		<?php //echo $form->labelEx($model,'CreatedDate'); ?>
		<?php //echo $form->textField($model,'CreatedDate'); ?>
		<?php //echo $form->error($model,'CreatedDate'); ?>



		<?php //echo $form->labelEx($model,'UpdatedDate'); ?>
		<?php //echo $form->textField($model,'UpdatedDate'); ?>
		<?php //echo $form->error($model,'UpdatedDate'); ?>



		<?php //echo $form->labelEx($model,'user_id'); ?>
		<?php //echo $form->textField($model,'user_id'); ?>
		<?php //echo $form->error($model,'user_id'); ?>

		<?php //echo $form->labelEx($model,'Views'); ?>
		<?php //echo $form->textField($model,'Views'); ?>
		<?php //echo $form->error($model,'Views'); ?>

		<?php //echo $form->labelEx($model,'Useful'); ?>
		<?php //echo $form->textField($model,'Useful'); ?>
		<?php //echo $form->error($model,'Useful'); ?>



		<?php //echo $form->labelEx($model,'Unuseful'); ?>
		<?php //echo $form->textField($model,'Unuseful'); ?>
		<?php //echo $form->error($model,'Unuseful'); ?>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

    <script>
        $(document).ready(function(){
            $('#change').click(function(event){
                event.preventDefault();

                $('#img').replaceWith('<?php echo $form->labelEx($model, 'image'); ?><?php echo $form->fileField($model, 'image'); ?><?php echo $form->error($model, 'image'); ?> ');
            });
        });
    </script>

</div><!-- form -->