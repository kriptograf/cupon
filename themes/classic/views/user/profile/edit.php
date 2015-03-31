<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);
//$this->menu=array(
//	((UserModule::isAdmin())
//		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
//		:array()),
//    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
//    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
//    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
//    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
//);
?>

<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->
        
        <div class="equal">
            
            <div class="main">
                
                <div class="profile-wrapper">
                    
                    <ul class="tabs">
                        <li class="tab1 current">Мои данные</li>
                        <li class="tab2">Мои купоны</li>
                      </ul>
        
                    <div class="title-companies">
                        <span style="display: inline-block;width: 40px;">&nbsp;</span>
                             <?php echo UserModule::t('Edit profile'); ?>
                    </div>

                        <?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
                        <div class="success">
                        <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
                        </div>
                        <?php endif; ?>
                        <div class="form-profile">
                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'profile-form',
                                'enableAjaxValidation'=>false,
                                'htmlOptions' => array('enctype'=>'multipart/form-data'),
                        )); ?>

                                <?php echo $form->errorSummary(array($model,$profile)); ?>

                                <?php
                                        $profileFields=$profile->getFields();
                                        if ($profileFields)
                                        {
                                                foreach($profileFields as $field)
                                                {
                                                ?>
                                <div class="row">
                                        <?php echo $form->labelEx($profile,$field->varname);

                                        if ($widgetEdit = $field->widgetEdit($profile))
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
                                                echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
                                        }
                                        echo $form->error($profile,$field->varname); ?>
                                </div>	
                                                <?php
                                                }
                                        }



                        ?>
                                <div class="row">
                                        <?php //echo $form->labelEx($model,'username'); ?>
                                        <?php echo $form->hiddenField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
                                        <?php //echo $form->error($model,'username'); ?>
                                </div>

                                <div class="row">
                                        <?php echo $form->labelEx($model,'email'); ?>
                                        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
                                        <?php echo $form->error($model,'email'); ?>
                                </div>
                            <?php echo $form->hiddenField($profile,'hideen_foto', array('value'=>$profile->photo));?>

                                <div class="buttons">
                                        <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class'=>'change')); ?>
                                </div>

                        <?php $this->endWidget(); ?>

                        </div><!-- form -->
                        
                   </div>

            </div>
            
            <div class="sidebar">
                <ul class="big-nav">
                    <li><a href="<?php echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>
                    <li><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Все акции</a> </li>
                </ul>
                <ul class="right-menu">
                    <?php foreach($catKupones as $cat):?>
                    <li><a href="<?php echo Yii::app()->createUrl('/kupones/category/'.$cat->id);?>"><?php echo $cat->name;?> <span class="count-cat"><?php echo $cat->countKupons; ?></span></a></li>
                    <?php endforeach;?>
                </ul>
            </div>  <!-- ### end sidebar section -->

        </div>

    </div>
</div>
