<?php
/**
 * Created by JetBrains PhpStorm.
 * User: foreach
 * Date: 06.03.13
 * Time: 0:02
 */ ?>
    <?php $form=$this->beginWidget('UActiveForm', array(
    'id'=>'registration-form',
    'action'=>'/user/registration',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    //'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>


    <div class="crops">
    <?php
    //$profileFields=$profile->getFields();
    //if ($profileFields)
    //{
        //foreach($profileFields as $field)
        //{
            //?>
                <!--<div class="spacer">-->
                <?php //echo $form->labelEx($profile,$field->varname); ?>
                <?php
                /*if ($widgetEdit = $field->widgetEdit($profile))
                {
                    echo $widgetEdit;
                }
                elseif ($field->range)
                {
                    echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
                }
                elseif ($field->field_type=="TEXT")
                {
                    echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
                }
                else
                {
                    $placeholder='';
                    if($field->varname == 'mobile')
                    {
                        $placeholder='+7900XXXXXXX';
                    }
                    elseif($field->varname == 'fio')
                    {
                        $placeholder='Виталий Москвин';
                    }
                    elseif($field->varname == 'birthday')
                    {
                        $placeholder='дд.мм.гггг';
                    }
                    echo $form->textField($profile,$field->varname,array('maxlength'=>(($field->field_size)?$field->field_size:255),'placeholder'=>$placeholder));
                }*/
                ?>
                <?php //echo $form->error($profile,$field->varname); ?>
                <!--</div>-->
            <?php
        //}
    //}
    ?>

        <div class="spacer">
            <?php //echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email',array('placeholder'=>'E-mail')); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>



        <div class="spacer">
            <?php //echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password',array('placeholder'=>'Пароль')); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="spacer">
            <?php //echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'verifyPassword',array('placeholder'=>'Повторите пароль')); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
        </div>

    </div>

    <?php //if (UserModule::doCaptcha('registration')): ?>
    <!--<div class="captcha">-->
        <?php //echo $form->labelEx($model,'verifyCode'); ?>

        <?php //$this->widget('CCaptcha',array(
                                       // 'clickableImage'=>true,
                                        //'showRefreshButton'=>true,
                                       // 'buttonLabel' => CHtml::image(Yii::app()->baseUrl. '/images/refresh.png','Обновить',array('class'=>'refresh','title'=>'Обновить картинку')),
                                       // 'imageOptions'=>array('alt'=>'Картинка с кодом валидации', 'title'=>'Чтобы обновить картинку, нажмите на нее'))); ?>
        <?php //echo $form->textField($model,'verifyCode'); ?>
        <?php //echo $form->error($model,'verifyCode'); ?>

    <!--</div>-->
    <?php //endif; ?>

    <div class="row submit">
        <?php echo CHtml::submitButton(UserModule::t("Register")); ?>
    </div>

    <div class="social-login">
        <div id="sLogin-label">Войти через соцсети:</div>
        <div id="uLoginBig"
             data-ulogin="display=panel;fields=first_name,last_name,email;
                            providers=vkontakte,odnoklassniki,facebook;
                            redirect_uri=http://<?php echo $_SERVER['HTTP_HOST'];?>/ulogin/login;"></div>

    </div>
    <script>
        uLogin.customInit("uLoginBig")
    </script>

    <?php $this->endWidget(); ?>
<script>
    $(document).ready(function(){

    });
</script>
