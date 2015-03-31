<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen, projection" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/facebox/facebox.css" />

    <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>-->
    <!--<script type="text/javascript" src="<?php //echo Yii::app()->request->baseUrl; ?>/js/news-scroll.js"></script>-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div class="page">
    <div class="header">
        <div class="top-heder">
            <div class="top-header-inner layout">
                <div class="cities">
                    <?php $this->widget('CitiesWidget');?>
                </div>
                <div class="search">
                    <?php $this->widget('SearchWidget');?>
                </div>
                <div class="social">
                    <?php  $this->widget('application.components.UloginWidget', array(
                        'params'=>array(
                            'display'=>'small',
                            'redirect'=>'http://'.$_SERVER['HTTP_HOST'].'/ulogin/login',
                            //Адрес, на который ulogin будет редиректить браузер клиента.
                            //Он должен соответствовать контроллеру ulogin и действию login
                            'providers'=>'vkontakte,odnoklassniki,facebook',
                            'hidden'=>'',
                        )
                    )); ?>
                </div>
                <?php if(Yii::app()->user->isGuest):?>
                <div class="sign">
                    <a href="#" class="login">
                        Войти
                    </a>
                    <a href="#" class="register">
                        Зарегистрироваться
                    </a>
                    <?php $this->widget('LoginWidget'); $this->widget('RegisterWidget');?>
                </div>
                <?php else:?>
                <div class="signout">
                    <p>Вы вошли как &nbsp;&nbsp;<strong><?php echo Yii::app()->user->name;?></strong></p>
                    <p>
                        <a href="<?php echo Yii::app()->createUrl('/user/profile', array('tab'=>'mykupons'))?>">Мои купоны</a>
                        |
                        <a href="/user/profile">Мой профиль</a>
                        |
                        <a href="/user/logout">Выйти</a>
                    </p>
                </div>
                <?php endif;?>
            </div>
        </div>
        <div class="middle-header">
            <div class="middle-header-inner layout">
                <div class="logo"  style="background: url('<?php echo $this->settings->logo;?>') no-repeat 0 10px;">
                    <a href="/"></a>
                    <div class="slogan">городская система лучших цен</div>
                    <div class="version">Версия <?php echo $this->settings->version;?></div>
                </div>
                <!-- ### news widget from news module -->
                <?php $this->widget('application.modules.news.components.FrontNewsWidget');?>

                <div class="economy">
                    <?php $this->widget('DigitWidget');?>

                </div>
            </div>
        </div>
        <div class="top-menu">
            <?php $this->widget('MenuWidget');?>
        </div>
        <div class="bottom-header layout">
            <?php $this->widget('application.modules.banner.components.FrontBannerWidget',array('pos'=>'TOP'));?>
        </div>
    </div> <!-- ### end header section -->


	<?php echo $content; ?>

    <div class="footer">
        <div class="footer-inner layout">
            <div class="copy">
                © 2012 «Суперценник.ру»  <br>Все права защищены
            </div>
            <div class="footer-menu">
                <?php $this->widget('MenuWidget');?>
            </div>
            <?php $this->widget('SocialWidget');?>
        </div>
    </div><!-- ### end footer section -->
<?php if(Yii::app()->user->hasFlash('message')):?>
        <script type="text/javascript">
            $(document).ready(function() {
                $.facebox('<?php echo Yii::app()->user->getFlash('message');?>');
                setTimeout(function() {
                    $('#facebox').fadeOut(600, function(){ $(this).remove();});
                    $('#facebox_overlay').fadeOut(600, function(){ $(this).remove();});
                }, 3000);
            });
        </script>
<?php endif;?>
</div><!-- ### end page section -->
<?php $module = (isset(Yii::app()->controller->module->id))?Yii::app()->controller->module->id:''?>
<script>
    $(document).ready(function(){
        if("<?php echo $module;?>"==="companies")
        {
            $('.companies').css('z-index',1000);
            $('.btm-line').css('background','url(/images/bg-catalog-ul.png) no-repeat scroll 0px 4px transparent');
        }
        if("<?php echo $module;?>"==="board")
        {
            $('.boards').css('z-index',1000);
            $('.btm-line').css('background','url(/images/bg-board-ul.png) no-repeat scroll 0px 4px transparent');
        }
    });
</script>
</body>
</html>
