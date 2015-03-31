
<div class="r" style="border-radius:10px; border:#CCC 1px solid; padding:10px 0 10px 10px;">
    <div style="font-family:'Trebuchet MS'; line-height:35px; margin-bottom:10px; font-size:25px; color:#282828;"><?php echo $model->action;?></div>
    <div style="width:670px; float:left;">
        <div style=" width:357px; float:left;">
            <?php 
            $url = 'http://geocode-maps.yandex.ru/1.x/?geocode='.urlencode($model->city->name.' '.$model->company->address);
            $result = file_get_contents($url);
            $xml = simplexml_load_string($result);
            $coords = (string)$xml->GeoObjectCollection->featureMember->GeoObject->Point->pos;
            $coords = str_replace(' ', ',', $coords);
            ?>
            <div id="map" style="width:357px; height:267px;">
                <img src="#" id="static-map" />
            </div>
            <script type="text/javascript">
                
                $(document).ready(function(){

                    var newsrc = "http://static-maps.yandex.ru/1.x/?ll=<?php echo $coords;?>&size=357,267&z=14&l=map&pt=<?php echo $coords;?>,flag";

                    var img = document.getElementById('static-map');

                    img.src = newsrc;
                });
                     
            </script>
        </div>
        <div style="width:313px; float:left;">
            <ul style="margin-left:20px;" class="priteddata">
                <li style="font-family:'Trebuchet MS'; font-size:25px; padding-bottom:5px;">
                    <font class="title">КОД вашего купона</font><br>
                    <font style="background:#D8E39F">&nbsp;<?php echo $model->code;?></font></li>
                <li><font class="title">Телефон: </font> <?php echo str_replace(',', '<br>', $model->company->phones);?></li>
                <li><font class="title">Адрес: </font> г.<?php echo $model->city->name;?> <?php echo $model->company->address;?></li>
                <li><font class="title">Воспользоваться купоном можно до </font> <?php echo date('d.m.Y h:i', strtotime($model->end_date));?></li>

            </ul>
        </div>
    </div>
</div>

<div class="r print-bottom">
    <div class="bottom-info" style="width:670px; float:left;text-align: center;">
        <div style=" width:670px; overflow:auto; text-align:left; line-height:17px;">
            <div id="specialchars" style="width:49%; float:left;">
                <div style="font-family:'Trebuchet MS'; line-height:35px; font-size:25px; color:#282828;padding-left: 20px;">Условия</div>
                <ul class="uslopp">
                    <?php echo $model->conditions;?>
                </ul>
            </div>
            <div class="specialchars" style="width:49%;float:right;">
                <div style="font-family:'Trebuchet MS'; line-height:35px; font-size:25px; color:#282828; padding-left: 20px;">Детали акции</div>
                <ul class="uslopp">
                    <?php echo $model->details;?>
                </ul>

            </div>
        </div>
    </div>
</div>
