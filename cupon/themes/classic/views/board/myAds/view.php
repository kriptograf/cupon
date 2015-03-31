<?php
/* @var $this AdsController */
/* @var $model Ads */

$this->breadcrumbs=array(
    'Ads'=>array('index'),
    $model->title,
);
?>



<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">

                <div id="form-title" class="title-section">
                    <h1 class="section-h1">Товары и ...</h1>

                    <span class="add-board">
                        <a href="/board/ads/create">Добавить объявление</a>
                    </span>
                    <span class="count-board">Объявлений / <?php echo $dataProvider->totalItemCount;?></span>
                </div>

                <!-- filter-->
                <?php //$this->widget('FilterWidget');?>

                <div class="spacer-view">
                    <a id="back" href="/board/ads/category/id/<?php echo $model->category_id;?>">К списку</a>

                    <a id="complain" href="#" onclick="$('#complain-dialog').dialog('open'); return false;">Пожаловаться</a>
                    <a id="print" href="#">Распечатать /</a>
                </div>

                <div id="left">
                    <div id="title">
                        <strong><?php echo $model->title;?></strong><br>
                        <span><?php echo ($model->price)?$model->price.' руб.':'Цена не указана';?></span>
                    </div>
                    <div id="contacts">
                        <h3>Контакты продавца</h3>
                    </div>
                    <div id="name"><?php echo $model->author;?></div>
                    <div id="phone"><?php echo $model->phone;?></div>
                    <div id="email"><?php echo $model->email;?></div>
                    <div id="date-pub">Дата подачи: <?php echo date('d.m.Y',$model->date_pub);?></div>

                    <?php if($model->address):?>
                        <?php if($model->x && $model->y):?>
                            <?php $coords = $model->x.','.$model->y;?>
                        <?php else:?>
                            <?php
                            $url = 'http://geocode-maps.yandex.ru/1.x/?geocode='.urlencode($model->address);
                            $result = file_get_contents($url);
                            $xml = simplexml_load_string($result);
                            $coords = (string)$xml->GeoObjectCollection->featureMember->GeoObject->Point->pos;
                            $coords = str_replace(' ', ',', $coords);
                            ?>
                        <?php endif;?>
                        <div id="map" style="height:170px;width: 250px;margin-top: 20px;"></div>

                        <script type="text/javascript">
                            window.onload = function () {
                                var map = new YMaps.Map(document.getElementById("map"));
                                map.setCenter(new YMaps.GeoPoint(<?php echo $coords;?>), 15);
                                // Создает метку в центре Москвы
                                var placemark = new YMaps.Placemark(new YMaps.GeoPoint(<?php echo $coords;?>));
                                // Устанавливает содержимое балуна
                                placemark.name = "<?php echo $model->address;?>";
                                placemark.description = "<?php echo $model->address;?>";
                                // Добавляет метку на карту
                                map.addOverlay(placemark);
                                map.addControl(new YMaps.SmallZoom());
                            };
                        </script>
                    <?php endif;?>
                </div>

                <div id="right">
                    <div id="thumbs">
                        <?php $images = $model->adsImgs;?>
                        <ul>
                            <?php foreach($images as $img):?>
                                <li>
                                    <a href="<?php echo $img->img;?>">
                                        <img src="<?php echo $img->thumb;?>">
                                    </a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <div id="big">
                        <img src="<?php echo $images[0]->img;?>">
                    </div>
                    <div id="details">
                        <p id="detail-title"><?php echo $model->title;?></p>
                        <p id="detail-text"><?php echo $model->details;?></p>
                        <p id="views">Просмотров: <?php echo $model->views;?></p>
                    </div>
                </div>

            </div>  <!-- ### end main section -->

            <div class="sidebar">
                <?php $this->widget('SectionsWidget');?>
            </div>  <!-- ### end sidebar section -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        //Смена изображения при клике
        $("#thumbs ul li a").click(function(event) {
            event.preventDefault();
            var mainImage = $(this).attr("href"); //Find Image Name
            $("#big img").attr({ src: mainImage });
            return false;
        });
        //вызов окна для печати
        $('#print').click(function(event){
            event.preventDefault();
            var url = '/board/ads/print/id/<?php echo $model->id;?>';
            openDialog(url,815,1147);
        });
    });
    function openDialog(url, width, height)
    {
        var params = ''
        params = "left="+((screen.width/2)-(width/2))+","
        params += "top="+((screen.height/2)-(height/2));
        win=window.open(url,"asd","toolbar=0,directories=0,menubar=0,status=0,width="+width+",height="+height+",resizable=1,scrollbars=1,"+params);
        win.focus();
        return win
    }
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'complain-dialog',
    'options' => array(
        'title' => 'Отправить жалобу',
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false,
        'width'=>450,
    ),
));
$qForm = new Complain();

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'comp-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'action' => array('/board/ads/complain'),
));
?>

<?php echo $form->errorSummary($qForm); ?>
<div class="row">
    <?php echo $form->labelEx($qForm,'name'); ?><br>
    <?php echo $form->textField($qForm,'name',array('style'=>'width:97%')); ?>
    <?php echo $form->error($qForm,'name'); ?>
</div>
<div class="row">
    <?php echo $form->labelEx($qForm,'text'); ?>
    <?php echo $form->textArea($qForm,'text', array('rows'=>10,'cols'=>40)); ?>
    <?php echo $form->error($qForm,'text'); ?>
</div>
<?php echo $form->hiddenField($qForm,'item', array('value'=>'http://'.$_SERVER['HTTP_HOST'].'/board/ads/view/id/'.$model->id)); ?>

<div class="row">
    <?php echo CHtml::submitButton('Отправить'); ?>
</div>
<?php
$this->endWidget();
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


