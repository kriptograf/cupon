<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login");
$this->breadcrumbs = array(
    UserModule::t("Login"),
);
?>

<?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

    <div class="success">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>

<?php endif; ?>


<?php echo CHtml::beginForm(); ?>
<?php if ($model->hasErrors()): ?>
    <div class="notification info">
        <div class="messages">
            <?php echo CHtml::errorSummary($model); ?>
        </div>
    </div>
<?php endif; ?>

<fieldset>

    <?php echo CHtml::activeLabelEx(new Cities(), 'name'); ?>
    <?php echo CHtml::activeDropDownList(new Cities(), 'id_city', CHtml::listData($cities, 'id_city', 'name'), array('class' => 'text'))?>
    
    
    <?php echo CHtml::activeLabelEx($model, 'username'); ?>
    <?php echo CHtml::activeTextField($model, 'username', array('class' => 'text')) ?>



    <?php echo CHtml::activeLabelEx($model, 'password'); ?>
    <?php echo CHtml::activePasswordField($model, 'password', array('class' => 'text')) ?>


    <?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => "submit")); ?>

    <?php echo CHtml::activeCheckBox($model, 'rememberMe', array('class' => "checkbox", 'checked' => "checked")); ?>
    <?php echo CHtml::activeLabelEx($model, 'rememberMe', array('class' => "remember_me",)); ?>
</fieldset>

<?php echo CHtml::endForm(); ?>



<?php
$form = new CForm(array(
    'elements' => array(
        'username' => array(
            'type' => 'text',
            'maxlength' => 32,
        ),
        'password' => array(
            'type' => 'password',
            'maxlength' => 32,
        ),
        'rememberMe' => array(
            'type' => 'checkbox',
        )
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => 'Login',
        ),
    ),
        ), $model);
?>