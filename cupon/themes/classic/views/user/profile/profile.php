<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
//$this->menu=array(
//	((UserModule::isAdmin())
//		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
//		:array()),
//    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
//    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
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
                    
                    <div class="box visible">
                        <div class="title-companies"><span style="display: inline-block;width: 40px;">&nbsp;</span>
                             <?php echo UserModule::t('Личные данные'); ?>
                        </div>

                        <?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
                        <div class="success">
                            <script>
                                $(document).ready(function(){
                                    alert("<?php echo Yii::app()->user->getFlash('profileMessage'); ?>");
                                });
                            </script>

                        </div>
                        <?php endif; ?>
                        
                        <p><a href="/user/profile/myCompanies">Мои компании</a></p>
                        <p><a href="/board/myAds">Мои объявления</a></p>
                        <table class="dataGrid">

                                <?php 
                                    $profileFields=ProfileField::model()->forOwner()->sort()->findAll();
                                    if ($profileFields) 
                                    {
                                        foreach($profileFields as $field) 
                                        {
                                                  // echo "<pre>"; print_r($field);
                                            //echo CVarDumper::dump($field->widget,10,true);
                                  ?>
                                <tr>
                                   <th class="label"><?php echo CHtml::encode(UserModule::t($field->title)); ?></th>
                                    <td><?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?></td>
                                </tr>
                                <?php
                                        }//$profile->getAttribute($field->varname)
                                    }
                                ?>
                                <tr>
                                   <th class="label"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></th>
                                   <td><?php echo CHtml::encode($model->email); ?></td>
                                </tr>

                        </table>

                        <p><a href="/user/profile/edit" class="change">Изменить данные</a></p>
                        <hr>
                        <p><a href="/user/profile/changepassword" class="change">Изменить пароль</a></p>
                    </div>
                    
                    <div class="box">
                            <!-- ### ajax infinity pagination widget -->
                            <?php
                            $this->widget('zii.widgets.CListView', array(
                                    'id' => 'list-actions',
                                    'dataProvider' => $mykupons,
                                    'itemView' => '_mykupons',
                                    'template' => '{items} {pager}',
                                )
                            );
                            ?>

                            <?php Yii::app()->getClientScript()->registerCssFile( Yii::app()->baseUrl.'/css/jquery.rating.css', 'screen, projection');?>
                            <?php Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.rating-2.0.js' , CClientScript::POS_HEAD);?>
                            <?php Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/rate.js' , CClientScript::POS_HEAD);?>

                    </div>
                    
                </div>

                <?php if(Yii::app()->request->getParam('tab')=='mykupons'):?>
                    <script>
                        $(document).ready(function(){
                            $('li:not(.current)').addClass('current').siblings().removeClass('current')
                                .parents('div.profile-wrapper').find('div.box').eq($(this).index()).fadeIn(150).siblings('div.box').hide();
                        });

                    </script>
                <?php endif;?>
                
                <script>
                        (function($) {
                            $(function() {

                              $('ul.tabs').delegate('li:not(.current)', 'click', function() {
                                $(this).addClass('current').siblings().removeClass('current')
                                  .parents('div.profile-wrapper').find('div.box').eq($(this).index()).fadeIn(150).siblings('div.box').hide();
                              })

                           })
                       })(jQuery);
                </script>
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