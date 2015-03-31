<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print/print.css"/>
</head>

<body style="background:none;">


    <div style="margin:0 auto;width:655px;height:1000px;text-align:left;">
        <div id="start" style="text-decoration: underline;cursor: pointer;text-align: right;">Распечатать</div>
        <div class="r" style="margin-bottom:15px;">
            <div style="float:left;width:300px; margin-top:15px;">
                <img src="/images/print-logo.jpg" style="max-width:300px;">
            </div>
            <div class="print-title" style="float:left;margin-left:10px;line-height:20px;margin-top:20px;width:340px;font-size:12px;">
                <span style="font-size:18px;">Скидочный купон</span><br>
                Предъявите этот купон на месте, чтобы получить услугу
            </div>
        </div>
        <?php echo $content;?>

    </div>


<script language="javascript">
   $(document).ready(function(){
       $('#start').click(function(){
           $.post('/kupones/kupons/activate',{id:"<?php echo Yii::app()->request->getParam('id');?>"});
           print(this);
       });
   });
</script>
</body>
</html>