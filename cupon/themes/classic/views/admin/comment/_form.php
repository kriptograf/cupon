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
            <?php echo $form->labelEx($model,'create_time'); ?>
            <?php echo $form->textField($model,'create_time'); ?>
            <?php echo $form->error($model,'create_time'); ?>
        <?php else:?>
            <?php echo $form->labelEx($model,'create_time'); ?>
            <?php echo $form->hiddenField($model,'create_time'); ?>
            <strong>
                <?php echo date("d.m.Y",$model->create_time);?>
            </strong>
        <?php endif;?>
    </div>


	<div class="row">
        <?php if($model->isNewRecord):?>
            <?php echo $form->labelEx($model,'owner_id'); ?>
            <?php echo $form->textField($model,'owner_id'); ?>
            <?php echo $form->error($model,'owner_id'); ?>
        <?php else:?>
            <?php echo $form->labelEx($model,'owner_id'); ?>
            <?php echo $form->hiddenField($model,'owner_id'); ?>
            <strong>
                <?php echo $model->company->title;?>
            </strong>
        <?php endif;?>
	</div>

	<div class="row">
        <?php if($model->isNewRecord):?>
            <?php echo $form->labelEx($model,'creator_id'); ?>
            <?php echo $form->textField($model,'creator_id'); ?>
            <?php echo $form->error($model,'creator_id'); ?>
        <?php else:?>
            <?php echo $form->labelEx($model,'creator_id'); ?>
            <?php echo $form->hiddenField($model,'creator_id'); ?>
            <strong>
                <?php
                /**
                 * Здесь у нас в качестве релешина используется сразу модель профиля
                 * Profile
                 */
                echo $model->user->fio;
                ?>
            </strong>
        <?php endif;?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'comment_text'); ?>
		<?php echo $form->textArea($model,'comment_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment_text'); ?>
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