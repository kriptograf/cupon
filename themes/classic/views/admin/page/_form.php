<?php
/* @var $this PageController */
/* @var $model Pages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pages-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
        <?php
        //Подключаем виджет редактора
        $this->widget('application.extensions.editor.CKkceditor',array(
            //конфигурация редактора и файлового менеджера
            "model"=>$model,                //атрибут model аналогия с $form->textArea, используется имя модели в элементе <textarea>
            "attribute"=>'text',         //Название поля в БД для сохранения текста. То же самое, что $form->textArea($model,'content'
            "height"=>'500px',//Высота окна редактора
            "width"=>'100%', //Ширина окна редактора
            //Здесь главное не напутать с путями
            "filespath"=>Yii::app()->basePath."/../media/",//Путь к файлам на сервере.Такая запись будет соответствовать расположению папки media на одном уровне с index.php
            "filesurl"=>Yii::app()->baseUrl."/media/",//URL который подставляется в редактор после загрузки файла на сервер.
            //файлы сохраняются в папку media/images
        ) );
        ?>
		<?php //echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
		<?php echo $form->textField($model,'keywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descr'); ?>
		<?php echo $form->textField($model,'descr',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'descr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->checkBox($model,'state'); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->