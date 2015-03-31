<?php
/* @var $this CategoriesCompanyController */
/* @var $model CategoriesCompany */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'categories-company-form',
        'enableAjaxValidation' => false,
    ));
    ?>


        <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php //echo $form->labelEx($model, 'parent_id'); ?>
        <?php //echo $form->dropDownList($model, 'parent_id', CHtml::listData($roots, 'id', 'name'), array('empty' => '-Корневая категория-')); ?>
        <?php //echo $form->error($model, 'parnt_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name'); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->checkBox($model,'status');  ?>
        <?php echo $form->error($model,'status');  ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->