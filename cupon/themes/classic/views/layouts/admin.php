<!DOCTYPE>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/reset.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" media="screen, projection" />

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/ie.css" media="screen, projection" />
    <![endif]-->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/jquery-tipsy.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/jquery-custom.js"></script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<table class="wrapper">
<tr>
    <td id="header" colspan="2">
        <div class="top">
            <p class="user">
                <span><?php echo Yii::app()->user->name;?></span>
                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->baseUrl);?>" target="_blank" title="Открыть сайт в новом окне">Открыть сайт</a> -
                <a href="/admin/parsing" title="settings">Пока не трогать</a> - 
                <a href="/user/logout" title="settings">Выйти</a>
            </p>
        </div>
        <div id="logo">
            <p class="logo">
                <a href="/admin" title="Панель управления">
                    <img src="/images/admin/admin-logo.png" alt="<?php echo CHtml::encode(Yii::app()->name); ?>">
                </a>
            </p>
            <div class="psefdo-menu">
                <span class="view">Просмотр</span>
                <a href="/user/logout" class="logout">Выйти</a>
            </div>
        </div>
    </td><!-- header -->
</tr>

<tr id="main-block">
        <td style="vertical-align: top;width: 27.5%;">
            <div id="menu">
                <?php $controller = Yii::app()->controller->id;?>
                <div class="menu-item">
                    <h3 class="open">
                        <img src="/images/admin/m-close.png" alt="" />Купоны</h3>
                    <div class="menu-overflow">
                        <div class="menu-content">
                            <?php $this->widget('zii.widgets.CMenu',array(
                                'encodeLabel'=>false,
                                'items'=>array(
                                    array('label'=>'&raquo; Управление купонами', 'url'=>array('/admin/kupons'), 'active'=>Yii::app()->controller->id=='kupons'),
                                    array('label'=>'&raquo; Активированные купоны', 'url'=>array('/admin/activated'),'active'=>Yii::app()->controller->id=='activated'),
                                    array('label'=>'&raquo; Категории купонов', 'url'=>array('/admin/categoriesKupon'), 'active'=>Yii::app()->controller->id=='categoriesKupon'),
                                    array('label'=>'&raquo; Управление отзывами ('.Comments::model()->count('status=0').')', 'url'=>array('/admin/comments'), 'active'=>Yii::app()->controller->id=='comments'),
                                ),
                            )); ?>
                        </div><!-- end div .menu-content -->
                    </div><!-- end div .menu-overflow -->
                </div><!-- end div .menu-item -->
                <div class="menu-item">
                    <?php if($controller =='companies' || $controller == 'categoriesCompany' || $controller == 'comment'):?>
                        <h3 class="open"><img src="/images/admin/m-close.png" alt="" />Компании</h3>
                    <?php else:?>
                        <h3 class="close"><img src="/images/admin/m-open.png" alt="" />Компании</h3>
                    <?php endif;?>
                    <div class="menu-overflow">
                        <div class="menu-content">
                            <?php $this->widget('zii.widgets.CMenu',array(
                                'encodeLabel'=>false,
                                'items'=>array(
                                    array('label'=>'&raquo; Категории компаний', 'url'=>array('/admin/categoriesCompany'), 'active'=>Yii::app()->controller->id=='categoriesCompany'),
                                    array('label'=>'&raquo; Компании', 'url'=>array('/admin/companies'), 'active'=>Yii::app()->controller->id=='companies'&&Yii::app()->controller->action->id=='admin'),
                                    array('label'=>'&raquo; Новые компании ('. Companies::getCountNew().')', 'url'=>array('/admin/companies/newCompany'), 'active'=>Yii::app()->controller->action->id=='newCompany'),
                                    array('label'=>'&raquo; Управление отзывами ('.Comment::model()->count('status=0').')', 'url'=>array('/admin/comment'), 'active'=>Yii::app()->controller->id=='comment'),
                                ),
                            )); ?>
                        </div><!-- end div .menu-content -->
                    </div><!-- end div .menu-overflow -->
                </div><!-- end div .menu-item -->
                <div class="menu-item">
                    <?php if($controller =='news'):?>
                        <h3 class="open"><img src="/images/admin/m-close.png" alt="" />Новости</h3>
                    <?php else:?>
                        <h3 class="close"><img src="/images/admin/m-open.png" alt="" />Новости</h3>
                    <?php endif;?>
                    <div class="menu-overflow">
                        <div class="menu-content">
                            <?php $this->widget('zii.widgets.CMenu',array(
                                'encodeLabel'=>false,
                                'items'=>array(
                                    array('label'=>'&raquo; Новости', 'url'=>array('/admin/news'), 'active'=>Yii::app()->controller->id=='news'),
                                ),
                            )); ?>
                        </div><!-- end div .menu-content -->
                    </div><!-- end div .menu-overflow -->
                </div><!-- end div .menu-item -->
                <div class="menu-item">
                    <?php if($controller =='banners' || $controller == 'position' || $controller == 'statistic'):?>
                        <h3 class="open"><img src="/images/admin/m-close.png" alt="" />Баннеры</h3>
                    <?php else:?>
                        <h3 class="close"><img src="/images/admin/m-open.png" alt="" />Баннеры</h3>
                    <?php endif;?>
                    <div class="menu-overflow">
                        <div class="menu-content">
                            <?php $this->widget('zii.widgets.CMenu',array(
                                'encodeLabel'=>false,
                                'items'=>array(
                                    array('label'=>'&raquo; Позиции баннеров', 'url'=>array('/admin/position'), 'active'=>Yii::app()->controller->id=='position'),
                                    array('label'=>'&raquo; Баннеры', 'url'=>array('/admin/banners'), 'active'=>Yii::app()->controller->id=='banners'),
                                    array('label'=>'&raquo; Статистика', 'url'=>array('/admin/statistic'), 'active'=>Yii::app()->controller->id=='statistic'),
                                ),
                            )); ?>
                        </div><!-- end div .menu-content -->
                    </div><!-- end div .menu-overflow -->
                </div><!-- end div .menu-item -->

                <div class="menu-item">
                    <?php if(Yii::app()->controller->module->id =='user'):?>
                        <h3 class="open"><img src="/images/admin/m-close.png" alt="" />Пользователи</h3>
                    <?php else:?>
                        <h3 class="close"><img src="/images/admin/m-open.png" alt="" />Пользователи</h3>
                    <?php endif;?>
                    <div class="menu-overflow">
                        <div class="menu-content">
                            <?php $this->widget('zii.widgets.CMenu',array(
                                'encodeLabel'=>false,
                                'items'=>array(
                                    array('label'=>'&raquo; Пользователи', 'url'=>array('/user/admin'), 'active'=>Yii::app()->controller->id=='admin'),
                                ),
                            )); ?>
                        </div><!-- end div .menu-content -->
                    </div><!-- end div .menu-overflow -->
                </div><!-- end div .menu-item -->

                <div class="menu-item">
                    <?php if(Yii::app()->controller->id =='settings'||Yii::app()->controller->id =='page' || Yii::app()->controller->id =='social' || Yii::app()->controller->id=='profileField'):?>
                        <h3 class="open"><img src="/images/admin/m-close.png" alt="" />Настройки</h3>
                    <?php else:?>
                        <h3 class="close"><img src="/images/admin/m-open.png" alt="" />Настройки</h3>
                    <?php endif;?>
                    <div class="menu-overflow">
                        <div class="menu-content">
                            <?php $this->widget('zii.widgets.CMenu',array(
                                'encodeLabel'=>false,
                                'items'=>array(
                                    array('label'=>'&raquo; Настройки сайта', 'url'=>array('/admin/settings'), 'active'=>Yii::app()->controller->id=='settings'),
                                    array('label'=>'&raquo; Поля профиля', 'url'=>array('/user/profileField/admin'), 'active'=>Yii::app()->controller->id=='profileField'&&Yii::app()->controller->action->id=='admin'),
                                    array('label'=>'&raquo; Города', 'url'=>array('/admin/cities'), 'active'=>Yii::app()->controller->id=='cities'),
                                    array('label'=>'&raquo; Статические страницы', 'url'=>array('/admin/page'), 'active'=>Yii::app()->controller->id=='page'),
                                    array('label'=>'&raquo; Мы в соцсетях', 'url'=>array('/admin/social'), 'active'=>Yii::app()->controller->id=='social'),
                                ),
                            )); ?>
                        </div><!-- end div .menu-content -->
                    </div><!-- end div .menu-overflow -->
                </div><!-- end div .menu-item -->

            </div>
        </td><!-- END SLIDEBAR -->

        <!-- BEGIN CONTENT -->
        <td id="content">

            <div class="box-out">
                <div class="box-in">

                    <?php //if(isset($this->breadcrumbs)):?>
                    <?php //$this->widget('zii.widgets.CBreadcrumbs', array(
                    //'links'=>$this->breadcrumbs,
                    // )); ?><!-- breadcrumbs -->
                    <?php //endif?>

                    <?php echo $content; ?>



                </div>
            </div>
        </td> <!-- END CONTENT -->
    </tr>



</table>
</body>
</html>