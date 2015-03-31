<?php
/* @var $this KuponsController */
/* @var $model Kupons */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kupons-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'action'); ?>
		<?php echo $form->textField($model,'action',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'action'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
        <?php echo $form->dropDownList($model, 'city_id',CHtml::listData(Cities::model()->findAll(),'id_city','name'), array('empty'=>'- город -'));?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_id'); ?>
        <?php echo $form->dropDownList($model, 'cat_id', CHtml::listData(CategoriesKupon::model()->findAll(),'id', 'name'), array('empty'=>'- категории купонов -'));?>
		<?php echo $form->error($model,'cat_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
        <?php echo $form->dropDownList($model, 'company_id', CHtml::listData(Companies::model()->findAll('checked=1'),'id', 'title'), array('empty'=>'- компания -'));?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

    <?php if($model->isNewRecord):?>
	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>
    <?php else:?>
        <div class="row">

            <?php echo $form->labelEx($model,'image'); ?>
            <?php echo $form->fileField($model,'image'); ?>
            <?php echo $form->error($model,'image'); ?>
            <br>
            <?php echo CHtml::image('/content/kupones/thumbs/'.$model->image,'thumb',array('style'=>'margin-left:200px;'));?>
        </div>
    <?php endif;?>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'old_price'); ?>
		<?php echo $form->textField($model,'old_price',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'old_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_price'); ?>
		<?php echo $form->textField($model,'new_price',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'new_price'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'start_date'); ?>

        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'name'=>'Kupons[start_date]',
            'value'=>($model->isNewRecord)?date('d.m.Y',time()):date('d.m.Y',strtotime($model->start_date)),
            'language'=>'ru',
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'fold',
            ),
        ));
        ?>
        <?php echo $form->error($model,'start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'end_date'); ?>

        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'name'=>'Kupons[end_date]',
            'value'=>($model->isNewRecord)?date('d.m.Y',time()):date('d.m.Y', strtotime($model->end_date)),
            'language'=>'ru',
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'fold',
            ),
        ));
        ?>
        <?php echo $form->error($model,'end_date'); ?>
    </div>


    <div class="row">
		<?php echo $form->labelEx($model,'conditions'); ?>
        <?php
        //Подключаем виджет редактора
        $this->widget('application.extensions.editor.CKkceditor',array(
            //конфигурация редактора и файлового менеджера
            "model"=>$model,                //атрибут model аналогия с $form->textArea, используется имя модели в элементе <textarea>
            "attribute"=>'conditions',         //Название поля в БД для сохранения текста. То же самое, что $form->textArea($model,'content'
            "height"=>'200px',//Высота окна редактора
            "width"=>'100%', //Ширина окна редактора
            //Здесь главное не напутать с путями
            "filespath"=>Yii::app()->basePath."/../media/",//Путь к файлам на сервере.Такая запись будет соответствовать расположению папки media на одном уровне с index.php
            "filesurl"=>Yii::app()->baseUrl."/media/",//URL который подставляется в редактор после загрузки файла на сервер.
            //файлы сохраняются в папку media/images
        ) );
        ?>
		<?php echo $form->error($model,'conditions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'details'); ?>
        <?php
        //Подключаем виджет редактора
        $this->widget('application.extensions.editor.CKkceditor',array(
            //конфигурация редактора и файлового менеджера
            "model"=>$model,                //атрибут model аналогия с $form->textArea, используется имя модели в элементе <textarea>
            "attribute"=>'details',         //Название поля в БД для сохранения текста. То же самое, что $form->textArea($model,'content'
            "height"=>'200px',//Высота окна редактора
            "width"=>'100%', //Ширина окна редактора
            //Здесь главное не напутать с путями
            "filespath"=>Yii::app()->basePath."/../media/",//Путь к файлам на сервере.Такая запись будет соответствовать расположению папки media на одном уровне с index.php
            "filesurl"=>Yii::app()->baseUrl."/media/",//URL который подставляется в редактор после загрузки файла на сервер.
            //файлы сохраняются в папку media/images
        ) );
        ?>
		<?php echo $form->error($model,'details'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->checkBox($model, 'status')?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'position'); ?>
		<?php //echo $form->textField($model,'position'); ?>
		<?php //echo $form->error($model,'position'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->