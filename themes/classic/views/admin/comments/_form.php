<?php
/* @var $this CommentsController  Админка форма добавления редактирования
 комментария(отзыва) об купоне
 */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php if($model->isNewRecord):?>
            <?php echo $form->labelEx($model,'date'); ?>
            <?php echo $form->textField($model,'date'); ?>
            <?php echo $form->error($model,'date'); ?>
        <?php else:?>
            <?php echo $form->labelEx($model,'date'); ?>
            <?php echo $form->hiddenField($model,'date'); ?>
            <strong>
                <?php echo date("d.m.Y",strtotime($model->date));?>
            </strong>
        <?php endif;?>
    </div>


	<div class="row">
        <?php if($model->isNewRecord):?>
            <?php echo $form->labelEx($model,'kupon_id'); ?>
            <?php echo $form->textField($model,'kupon_id'); ?>
            <?php echo $form->error($model,'kupon_id'); ?>
        <?php else:?>
            <?php echo $form->labelEx($model,'kupon_id'); ?>
            <?php echo $form->hiddenField($model,'kupon_id'); ?>
            <strong>
                <?php echo $model->kupon->action;?>
            </strong>
        <?php endif;?>
	</div>

	<div class="row">
        <?php if($model->isNewRecord):?>
            <?php echo $form->labelEx($model,'user_id'); ?>
            <?php echo $form->textField($model,'user_id'); ?>
            <?php echo $form->error($model,'user_id'); ?>
        <?php else:?>
            <?php echo $form->labelEx($model,'user_id'); ?>
            <?php echo $form->hiddenField($model,'user_id'); ?>
            <strong>
                <?php echo $model->user->profile->fio;?>
            </strong>
        <?php endif;?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->