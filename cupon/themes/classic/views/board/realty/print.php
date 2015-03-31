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

        <?php //$this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">

                <!-- filter-->
                <?php //$this->widget('FilterWidget');?>

                <div id="left" style="width: 205px;">
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
                        <div id="map" style="height:150px;width: 200px;margin-top: 20px;"></div>

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

                <div id="right" style="width: 535px;">
                    <div id="thumbs">
                        <?php $images = $model->realtyImg;?>
                        <ul style="padding: 0;">
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
    });
</script>

