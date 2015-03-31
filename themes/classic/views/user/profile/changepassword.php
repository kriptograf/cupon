<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Change Password"),
);
//$this->menu=array(
//	((UserModule::isAdmin())
//		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
//		:array()),
//    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
//    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
//    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
//    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
//);
?>

<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->
        
        <div class="equal">
            
            <div class="main">
        

<div class="title-companies"><span style="display: inline-block;width: 40px;">&nbsp;</span>
     <?php echo UserModule::t("Change password"); ?>
</div>
<div class="form-profile">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'oldPassword'); ?>
	<?php echo $form->passwordField($model,'oldPassword'); ?>
	<?php echo $form->error($model,'oldPassword'); ?>
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
	
	
	<div class="buttons">
	<?php echo CHtml::submitButton(UserModule::t("Save"), array('class'=>'change')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

            </div><!-- ### end main section -->
            
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