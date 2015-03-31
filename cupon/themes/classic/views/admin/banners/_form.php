<?php
/* @var $this BannersController */
/* @var $model Banners */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'banners-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    ));
    ?>
        <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name'); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'url'); ?>
        <?php echo $form->textArea($model, 'url', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'url'); ?>
    </div>

    <div class="row">
        <?php if(!$model->isNewRecord):?>
            <div id="img">
                <img src="/content/banners/<?php echo $model->img;?>" width="80%">
                <br>
                <a href="#" id="change">Изменить</a>
                <?php echo $form->hiddenField($model, 'img', array('value'=>$model->img)); ?>
            </div>
        <?php else:?>
            <?php echo $form->labelEx($model, 'img'); ?>
            <?php echo $form->fileField($model, 'img'); ?>
            <?php echo $form->error($model, 'img'); ?>
        <?php endif;?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'alt'); ?>
        <?php echo $form->textField($model, 'alt'); ?>
        <?php echo $form->error($model, 'alt'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'html'); ?>
        <?php echo $form->textArea($model, 'html', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'html'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'city_id'); ?>
        <?php echo $form->dropDownList($model, 'city_id', CHtml::listData(Cities::model()->findAll(), 'id_city', 'name'), array('empty' => '- город -')); ?>
        <?php echo $form->error($model, 'city_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'user_id'); ?>
        <?php echo $form->dropDownList($model, 'user_id', CHtml::listData(User::model()->findAll(), 'id', 'username'), array('empty' => '- рекламодатель -')); ?>
        <?php echo $form->error($model, 'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'width'); ?>
        <?php echo $form->textField($model, 'width'); ?>
        <?php echo $form->error($model, 'width'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'height'); ?>
        <?php echo $form->textField($model, 'height'); ?>
        <?php echo $form->error($model, 'height'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'percent'); ?>
        <?php echo $form->textField($model, 'percent'); ?>
        <?php echo $form->error($model, 'percent'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'pos_id'); ?>
        <?php echo $form->dropDownList($model, 'pos_id', CHtml::listData(PosBanner::model()->findAll(), 'id', 'title'), array('empty' => '- позиция -')); ?>
        <?php echo $form->error($model, 'pos_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'num'); ?>
        <?php echo $form->textField($model, 'num'); ?>
        <?php echo $form->error($model, 'num'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'sdate'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'name' => 'Banners[sdate]',
            'value' => ($model->isNewRecord)?'':date('d.m.Y', strtotime($model->sdate)),
            'language' => 'ru',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
            ),
        ));
        ?>
        <?php echo $form->error($model, 'sdate'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'edate'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'name' => 'Banners[edate]',
            'value' => ($model->isNewRecord)?'':date('d.m.Y', strtotime($model->edate)),
            'language' => 'ru',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
            ),
        ));
        ?>
        <?php echo $form->error($model, 'edate'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'views'); ?>
        <?php echo $form->textField($model, 'views', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'views'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'clicks'); ?>
        <?php echo $form->textField($model, 'clicks', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'clicks'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->checkBox($model, 'status') ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

<?php $this->endWidget(); ?>
<script>
    $(document).ready(function(){
        $('#change').click(function(event){
            event.preventDefault();

            $('#img').replaceWith('<?php echo $form->labelEx($model, 'img'); ?><?php echo $form->fileField($model, 'img'); ?><?php echo $form->error($model, 'img'); ?> ');
        });
    });
</script>
</div><!-- form -->