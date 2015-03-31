<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_city'); ?>
		<?php echo $form->textField($model,'id_city'); ?>
		<?php echo $form->error($model,'id_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textArea($model,'tags',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IsFeatured'); ?>
		<?php echo $form->textField($model,'IsFeatured'); ?>
		<?php echo $form->error($model,'IsFeatured'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CreatedDate'); ?>
		<?php echo $form->textField($model,'CreatedDate'); ?>
		<?php echo $form->error($model,'CreatedDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UpdatedDate'); ?>
		<?php echo $form->textField($model,'UpdatedDate'); ?>
		<?php echo $form->error($model,'UpdatedDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Views'); ?>
		<?php echo $form->textField($model,'Views'); ?>
		<?php echo $form->error($model,'Views'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Useful'); ?>
		<?php echo $form->textField($model,'Useful'); ?>
		<?php echo $form->error($model,'Useful'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Unuseful'); ?>
		<?php echo $form->textField($model,'Unuseful'); ?>
		<?php echo $form->error($model,'Unuseful'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->