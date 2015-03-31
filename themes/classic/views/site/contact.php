<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

    <div class="wrapper layout">
        <div class="wrapper-inner">
            <div class="main-menu">
                <ul class="tab-menu">
                    <li class="kupones"><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Купоны</a></li>
                    <li class="companies"><a href="<?php echo Yii::app()->createUrl('/companies');?>">Справочник</a></li>
                    <li class="boards">Бесплатные объявления</li>
                </ul>
                <div class="btm-line"></div>
            </div><!-- ### end main menu -->

            <div class="equal">
                <div class="main">
                    <div class="company-about">
                        <h2><?php echo $contacts->title; ?></h2>
                    </div>
                    <div class="noreset">
                        <?php echo $contacts->text;?>
                    </div>

                    <?php if(Yii::app()->user->hasFlash('contact')): ?>

                        <div class="flash-success">
                            <?php echo Yii::app()->user->getFlash('contact'); ?>
                        </div>

                    <?php else: ?>

                        <div class="form">

                            <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'contact-form',
                                'enableClientValidation'=>true,
                                'clientOptions'=>array(
                                    'validateOnSubmit'=>true,
                                ),
                            )); ?>

                            <?php echo $form->errorSummary($model); ?>

                            <div class="row">
                                <?php echo $form->labelEx($model,'name'); ?>
                                <?php echo $form->textField($model,'name'); ?>
                                <?php echo $form->error($model,'name'); ?>
                            </div>

                            <div class="row">
                                <?php echo $form->labelEx($model,'email'); ?>
                                <?php echo $form->textField($model,'email'); ?>
                                <?php echo $form->error($model,'email'); ?>
                            </div>

                            <div class="row">
                                <?php echo $form->labelEx($model,'subject'); ?>
                                <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
                                <?php echo $form->error($model,'subject'); ?>
                            </div>

                            <div class="row">
                                <?php echo $form->labelEx($model,'body'); ?>
                                <?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
                                <?php echo $form->error($model,'body'); ?>
                            </div>

                            <?php if(CCaptcha::checkRequirements()): ?>
                                <div class="row">
                                    <?php echo $form->labelEx($model,'verifyCode'); ?>
                                    <div>
                                        <?php $this->widget('CCaptcha'); ?>
                                        <?php echo $form->textField($model,'verifyCode'); ?>
                                    </div>
                                    <div class="hint">Введите символы изображенные на картинке.
                                        <br/>Символы регистронезавсимы.</div>
                                    <?php echo $form->error($model,'verifyCode'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="row buttons">
                                <?php echo CHtml::submitButton('Отправить'); ?>
                            </div>

                            <?php $this->endWidget(); ?>

                        </div><!-- form -->

                    <?php endif; ?>

                </div>  <!-- ### end main section -->
                <div class="sidebar">
                    <ul class="big-nav">
                        <li><a href="<?php echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>
                        <li><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Все акции</a>
                    </ul>
                    <ul class="right-menu">
                        <?php foreach($categories as $category):?>
                            <li><a href="<?php echo Yii::app()->createUrl('/category/'.$category->id);?>"><?php echo $category->name;?> <span class="count-cat"><?php echo $category->countKupons; ?></span></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>  <!-- ### end sidebar section -->
            </div>

        </div>
    </div>


