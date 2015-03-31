<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/reset.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/astyle.css" media="screen, projection" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/ie.css" media="screen, projection" />
    <![endif]-->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/jquery-custom.js"></script>
</head>
<body>
<div class="shadow-login"></div><!-- end div .shadow-login -->
<!-- BEGIN LOGIN -->
<div id="login">
    <p class="logo">
        <a href="/admin/login" title="Вход в защищенную зону">
            <img src="/images/admin/admin-logo.png" alt="SuperЦенник.ру">
        </a>
    </p>
    <div class="box-out">
        <div class="box-in">
            <?php echo $content;?>
        </div><!-- end div .box-in -->
    </div><!-- end div .box-out -->
</div><!-- end div #login -->
<!-- END LOGIN -->

</body>

</html>