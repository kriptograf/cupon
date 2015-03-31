<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>
<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">

            <div class="main">
                <div class="title-companies"><span style="display: inline-block;width: 40px;">&nbsp;</span>
                    <?php echo UserModule::t("Login"); ?>
                </div>

                    <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

                    <script>
                        alert("<?php echo Yii::app()->user->getFlash('loginMessage'); ?>");
                    </script>

                    <?php endif; ?>

                    <div class="form-profile">
                    <?php echo CHtml::beginForm(); ?>



                        <?php echo CHtml::errorSummary($model); ?>

                        <div class="row">
                            <?php echo CHtml::activeLabelEx($model,'username'); ?>
                            <?php echo CHtml::activeTextField($model,'username') ?>
                        </div>

                        <div class="row">
                            <?php echo CHtml::activeLabelEx($model,'password'); ?>
                            <?php echo CHtml::activePasswordField($model,'password') ?>
                        </div>

                        <div class="row">
                            <p class="hint">
                            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
                            </p>
                        </div>

                        <div class="row rememberMe">
                            <?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
                            <?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
                        </div>

                        <div class="buttons">
                            <?php echo CHtml::submitButton(UserModule::t("Login"),array('class'=>'change')); ?>
                        </div>

                    <?php echo CHtml::endForm(); ?>
                    </div><!-- form -->


                    <?php
                    $form = new CForm(array(
                        'elements'=>array(
                            'username'=>array(
                                'type'=>'text',
                                'maxlength'=>32,
                            ),
                            'password'=>array(
                                'type'=>'password',
                                'maxlength'=>32,
                            ),
                            'rememberMe'=>array(
                                'type'=>'checkbox',
                            )
                        ),

                        'buttons'=>array(
                            'login'=>array(
                                'type'=>'submit',
                                'label'=>'Login',
                            ),
                        ),
                    ), $model);
                    ?>
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
