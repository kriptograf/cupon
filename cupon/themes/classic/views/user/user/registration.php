<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>
<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">

            <div class="main">
                <div class="title-companies"><span style="display: inline-block;width: 40px;">&nbsp;</span>
                    <?php echo UserModule::t("Registration"); ?>
                </div>

                <?php if(Yii::app()->user->hasFlash('registration')): ?>
                <script>
                    alert("<?php echo Yii::app()->user->getFlash('registration'); ?>");
                </script>
                <?php else: ?>

                <div class="form-profile">
                <?php $form=$this->beginWidget('UActiveForm', array(
                    'id'=>'registration-form',
                    'enableAjaxValidation'=>true,
                    'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                    'htmlOptions' => array('enctype'=>'multipart/form-data'),
                )); ?>



                    <?php echo $form->errorSummary(array($model,$profile)); ?>

                    <div class="row">
                        <?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->textField($model,'email'); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </div>

                    <div class="row">
                    <?php //echo $form->labelEx($model,'username'); ?>
                    <?php //echo $form->textField($model,'username'); ?>
                    <?php //echo $form->error($model,'username'); ?>
                    </div>

                    <div class="row">
                    <?php echo $form->labelEx($model,'password'); ?>
                    <?php echo $form->passwordField($model,'password'); ?>
                    <?php echo $form->error($model,'password'); ?>
                    <p class="hint">
                    <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
                    </p>
                    </div>

                    <div class="row">
                    <?php echo $form->labelEx($model,'verifyPassword'); ?>
                    <?php echo $form->passwordField($model,'verifyPassword'); ?>
                    <?php echo $form->error($model,'verifyPassword'); ?>
                    </div>



                <?php
                        //$profileFields=$profile->getFields();
                        //if ($profileFields) {
                            //foreach($profileFields as $field) {
                            ?>
                    <div class="row">
                        <?php //echo $form->labelEx($profile,$field->varname); ?>
                        <?php
                        //if ($widgetEdit = $field->widgetEdit($profile)) {
                            //echo $widgetEdit;
                        //} elseif ($field->range) {
                            //echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
                        //} elseif ($field->field_type=="TEXT") {
                            //echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
                        //} else {
                           // echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
                        //}
                         ?>
                        <?php //echo $form->error($profile,$field->varname); ?>
                    </div>
                            <?php
                            //}
                       // }
                ?>
                    <?php if (!UserModule::doCaptcha('registration')): ?>
                    <div class="row">
                        <?php echo $form->labelEx($model,'verifyCode'); ?>

                        <?php $this->widget('CCaptcha'); ?>
                        <?php echo $form->textField($model,'verifyCode'); ?>
                        <?php echo $form->error($model,'verifyCode'); ?>

                        <p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
                        <br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="buttons">
                        <?php echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'change')); ?>
                    </div>

                <?php $this->endWidget(); ?>
                </div><!-- form -->
                <?php endif; ?>
            </div><!-- ### end main section -->

            <div class="sidebar">
                <ul class="big-nav">
                    <!--                <li><a href="<?php //echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>-->
                    <li><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Все акции</a>
                </ul>
                <?php $this->widget('CTreeView',
                    array(
                        'id'=>'treecategory',
                        'cssFile'=>'/css/jquery.treeview.css',
                        'data' => CategoriesCompany::generateTree(),
                        'collapsed'=>true,
                        'persist'=>'cookie',
                        'animated'=>'slow',
                        'htmlOptions'=>array(
                            'class'=>'right-menu'
                        ),
                    )
                );
                ?>
                <!--            <ul class="right-menu">
                    <?php //foreach($categories as $category):?>
                    <li><a href="<?php //echo Yii::app()->createUrl('/category/'.$category->id);?>"><?php //echo $category->name;?> <span class="count-cat"><?php //echo $category->countCompanies; ?></span></a></li>
                    <?php //endforeach;?>
                </ul>-->
            </div>  <!-- ### end sidebar section -->

        </div>
    </div>
</div>