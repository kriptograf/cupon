<?php
/* @var $this SettingsController */
/* @var $model Settings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'settings-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div style="height: 30px;"></div>
    <p class="hint">Загрузите изображение размером 414х36 пикселей</p>
	<div class="row upl">
		<?php echo $form->labelEx($model,'logo'); ?>
		<?php echo $form->fileField($model,'logo'); ?>
		<?php echo $form->error($model,'logo'); ?>
	</div>

    <div class="row finder">
        <script type="text/javascript">
            function openKCFinder(field) {
                window.KCFinder = {
                    callBack: function(url) {
                        field.value = url;
                        window.KCFinder = null;
                    }
                };
                window.open('/kcfinder/browse.php?type=files&dir=/images/site', 'kcfinder_textbox',
                    'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                        'resizable=1, scrollbars=0, width=800, height=600'
                );
            }
        </script>

        <label>Посмотреть на сервере</label>
        <input id="serv" name="Settings[logo2]" type="text" readonly="readonly" onclick="openKCFinder(this)"
               value="Нажмите,чтобы посмотреть на сервере." style="width:300px;cursor:pointer" />

    </div>
    <script>
        $(document).ready(function(){
           $('#Settings_logo').click(function(){
               $('#serv').val('');
               //$('.finder').hide();
           });
            $('#serv').click(function(){
                $('#Settings_logo').val('');
                $('#Settings_logo').attr('readonly','readonly');
            });
        });
    </script>


	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'version'); ?>
		<?php echo $form->textField($model,'version',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'version'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->