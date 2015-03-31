<?php $form=$this->beginWidget('UActiveForm', array(
    'id'=>'login-form',
    'action'=>'/user/login',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

<div class="crop">
    <div class="spacer-login">
        <?php echo CHtml::activeTextField($model,'username', array('placeholder'=>'Email')); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>
    <div class="spacer-pass">
        <?php echo CHtml::activePasswordField($model,'password', array('placeholder'=>'Пароль')) ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="spacer-remember">
        <a href="/user/recovery">Забыли пароль?</a>
    </div>

    <div id="output"></div>

</div>


<div class="spacer-submit" style="">
    <?php echo CHtml::ajaxSubmitButton(UserModule::t("Войти"),'/user/login',array(
            'type' => 'POST',
            // Результат запроса записываем в элемент, найденный
            // по CSS-селектору #output.
            'update' => '#output',
        ),
        array(
            // Меняем тип элемента на submit, чтобы у пользователей
            // с отключенным JavaScript всё было хорошо.
            'type' => 'submit'
        )); ?>
</div>
<div class="r-me">
    <?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
    <?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
</div>


<?php $this->endWidget(); ?>