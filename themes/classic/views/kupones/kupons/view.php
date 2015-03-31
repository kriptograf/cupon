<?php
/* @var $this KuponsController */
/* @var $model Kupons */

$this->breadcrumbs=array(
	'Kupons'=>array('index'),
	$model->id_kupon,
);

/*$this->menu=array(
	array('label'=>'List Kupons', 'url'=>array('index')),
	array('label'=>'Create Kupons', 'url'=>array('create')),
	array('label'=>'Update Kupons', 'url'=>array('update', 'id'=>$model->id_kupon)),
	array('label'=>'Delete Kupons', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_kupon),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Kupons', 'url'=>array('admin')),
); */
?>

<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">
                <div class="detail-kupon" id="dk">
                    <div class="top-info">
                        <table width="100%">
                            <tr>
                                <td width="110px" style="vertical-align: middle;">
                                    <div class="top-info-logo">
                                        <img src="/content/companies/logo/<?php echo $model->company->logo;?>" alt="<?php echo $model->company->title;?>">
                                    </div>
                                </td>
                                <td width="135px" style="border-right: 1px solid #e5e6e7;vertical-align: top;">
                                    <div class="top-info-address">
                                        <?php echo $model->company->address;?>
                                    </div>
                                </td>
                                <td width="150px" style="border-right: 1px solid #e5e6e7;">
                                    <div class="top-info-phones">
                                        <?php echo str_replace(',', '<br>', $model->company->phones);?>
                                    </div>
                                </td>
                                <td width="75px">
                                    <span id="btn-map" title="Показать на карте">&nbsp;</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php if($model->company->x && $model->company->y):?>
                        <?php $coords = $model->company->x.','.$model->company->y;?>
                    <?php else:?>
                        <?php
                        $url = 'http://geocode-maps.yandex.ru/1.x/?geocode='.urlencode($model->company->address);
                        $result = file_get_contents($url);
                        $xml = simplexml_load_string($result);
                        $coords = (string)$xml->GeoObjectCollection->featureMember->GeoObject->Point->pos;
                        $coords = str_replace(' ', ',', $coords);
                        ?>
                    <?php endif;?>
                    <div class="detail-image">
                        <span class="big-ticket">
                            <span class="tax"><?php echo $model->tax;?>%</span><br>
                            <span>скидки</span>
                            <span class="ticket-date">до <?php echo date('d.m.Y',strtotime($model->end_date));?></span>
                        </span>
                        <img src="/content/kupones/<?php echo $model->image;?>">
                    </div>
                    <div class="detail-map" style="display: none;padding: 5px;">
                        <div id="map" style="width: 512px;height: 300px;"></div>
                    </div>
                    <div class="detail-action-name">
                        <?php echo $model->action;?>
                    </div>
                </div>
                <!-- ### detail action section -->
                <div class="detail-action" id="da">
                    <h1>До завершения акции осталось:</h1>
                    <script language="JavaScript">
                        TargetDate = "<?php echo date('m/d/Y h:i', strtotime($model->end_date));?>";
                        BackColor = "palegreen";
                        ForeColor = "navy";
                        CountActive = true;
                        CountStepper = -1;
                        LeadingZero = true;
                        DisplayFormat = "%%D%% дн.<br> %%H%% <b>:</b> %%M%% <b>:</b> %%S%% часов";
                        FinishMessage = "Срок действия акции завершен!";
                    </script>
                    <div class="timer" id="countdown">
                        <span id="end"></span>
                    </div>

                    <div class="detail-prices">
                        <div class="old-price"><span class="digit"><?php echo (int)$model->old_price;?> </span>&nbsp;<span class="currency">р.</span></div>
                        <div class="new-price"><?php echo (int)$model->new_price;?> <span class="currency">р.</span></div>
                    </div>

                    <div class="get-kupon">
                        <div class="get-info">
                            Чтобы воспользоваться скидкой нажмите на
                            кнопку и распечатайте купон или сфотографируйте его на любое устройство<br>
                        </div>
                        <div class="get-form-kupon">
                            <a href="<?php if(Yii::app()->user->isGuest):?>false<?php else:?>/kupones/kupons/print/id/<?php echo $model->id_kupon;?><?php endif;?>" id="print">
                                <img src="/images/getkupon.png" />
                            </a>
                        </div>
                    </div>

                    <div class="other">
                        <div class="review"><?php echo $model->views;?></div>
                        <div class="count-comments"><?php echo $model->countComments;?></div>

                        <div class="rating">
                            <?php
                                $this->widget('CStarRating',array(
                                    'name'=>'rating',
                                    'maxRating'=>5,
                                    'allowEmpty' => false,
                                    'readOnly' => Yii::app()->user->isGuest || Yii::app()->request->cookies['kupon_'.$model->id_kupon]->value,
                                    'value'=> $model->rating,
                                    'callback'=>'function(){
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "'.Yii::app()->createUrl('kupones/rate').'",
                                                        data: "id='.$model->id_kupon.'&rate=" + $(this).val(),
                                                        dataType : "json",
                                                        success: function(msg){
                                                            alert(msg.msg);
                                                            $("#rating > input").rating("readOnly", true);
                                                        }
                                                    })
                                                }',
                                ));
                            ?>
                        </div>
                        <div class="delimiter"></div>

                    </div>

                    <div class="share">
                        <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                        <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,odnoklassniki"></div>
                    </div>
                </div> <!-- ### end detail action section -->
                    <script>
                        $(document).ready(function(){
                            $('#dk,#da').equalHeightColumns();
                        });
                    </script>
                <div class="detail-about">
                    <div class="action-text">
                        <h2>Условия акции</h2>
                        <div>
                            <p>Воспользоваться купоном можно до <?php echo date('d.m.Y',strtotime($model->end_date));?></p>
                            <?php echo $model->conditions;?>
                        </div>
                    </div>
                    <div class="terms-text">
                        <h2>Детали акции</h2>
                        <div>
                            <?php echo $model->details;?>
                        </div>
                    </div>
                    <div class="comments">
                        <span id="comm-view">Отзывы об акции</span>
                        <div id="comments-view">
                            <div id="ajax-comments">

                            </div>
                            <?php if(!Yii::app()->user->isGuest):?>
                            <div class="form">

                                <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'comments-form',
                                'enableAjaxValidation'=>true,
                            )); ?>

                                <?php echo $form->errorSummary($comments); ?>

                                <div class="row">
                                    <?php echo $form->hiddenField($comments,'kupon_id'); ?>
                                </div>

                                <div class="row">
                                    <?php echo $form->hiddenField($comments,'user_id', array('value'=>Yii::app()->user->id)); ?>
                                </div>

                                <div class="row">
                                    <?php echo $form->labelEx($comments,'content'); ?>
                                    <?php echo $form->textArea($comments,'content',array('rows'=>6, 'cols'=>70)); ?>
                                    <?php echo $form->error($comments,'content'); ?>
                                </div>

                                <div class="row buttons">
                                    <?php
                                    // Второй параметр пуст, значит отсылаем данные на тот же URL.
                                    // Третий параметр задаёт опции запроса. Подробнее с ними можно
                                    // ознакомиться в документации jQuery.
                                    echo CHtml::ajaxSubmitButton('Добавить отзыв', '/kupones/comments/create', array(
                                            'type' => 'POST',
                                            'dataType'=>'json',
                                            'success'=>'js:function(data){
                                                if(data.result==="success"){
                                                    $("#list-comment").prepend(data.comment);
                                                    $(".form").remove();
                                                }else{
                                                    alert("Ошибка при добавления отзыва");
                                                }
                                            }',
                                        ),
                                        array(
                                            'id'=>'ajax-submit',
                                        ));

                                    ?>
                                </div>

                                <?php $this->endWidget(); ?>

                            </div><!-- form -->
                            <?php endif;?>
                        </div>
                        <script>
                            $(document).ready(function(){
                               //$('#comm-view').click(function(){
                                   $.get('/kupones/comments/index/id/<?php echo $model->id_kupon;?>', function(data){
                                       $('#ajax-comments').html(data.comments);
                                       if(data.flag == 0)
                                       {
                                           $('.form').remove();
                                       }
                                       //$('#comments-view').slideToggle("slow");
                                       $('#Comments_kupon_id').val(<?php echo $model->id_kupon;?>)
                                   },'json');
                               //});
                            });
                        </script>
                    </div>
                </div>

                <div class="detail-about">
                 <div style="padding: 10px 10px 20px;overflow: hidden;">
                    <div class="company-about">
                        <h2>О компании</h2>
                    </div>

                    <div class="top-about">
                        <div class="about-logo">
                            <a href="<?php echo $this->createUrl('/companies/'.$model->company->category->id.'/'.$model->company->id);?>">
                                <img src="/content/companies/logo/<?php echo $model->company->logo;?>" />
                            </a>
                        </div>
                        <div class="datas">
                            <div class="address">
                                <?php echo $model->company->address;?>
                            </div> <br>
                            <div class="phones">
                                <?php
                                $phone = explode(',', $model->company->phones);
                                foreach($phone as $p)
                                {
                                    echo $p.'<br>';
                                }
                                ?>
                            </div>
                            <br />
                            <div class="schedule">
                                <?php echo $model->company->schedule;?>
                            </div>
                            <br />
                            <?php if($model->company->link):?>
                            <div class="link">
                                <?php
                                if(!substr_count($model->company->link,'http://',0,7))
                                {
                                    $model->company->link = 'http://'.$model->company->link;
                                }
                                ?>
                                <?php echo CHtml::link(CHtml::encode(str_replace('http://','',$model->company->link)), $model->company->link, array('target'=>'_blank')); ?>
                            </div>
                            <?php endif;?>
                        </div>

                        <div class="map">
                            <div id="map2" style="width: 100%; height: 100%;margin-left: 5px; margin-top: 2px;"></div>

                            <script type="text/javascript">
                            window.onload = function () {
                                var map = new YMaps.Map(document.getElementById("map2"));
                                map.setCenter(new YMaps.GeoPoint(<?php echo $coords;?>), 15);
                                // Создает метку в центре Москвы
                                var placemark = new YMaps.Placemark(new YMaps.GeoPoint(<?php echo $coords;?>));
                                // Устанавливает содержимое балуна
                                placemark.name = "<?php echo $model->city->name;?>";
                                placemark.description = "<?php echo $model->company->address;?>";
                                // Добавляет метку на карту
                                map.addOverlay(placemark);
                                map.addControl(new YMaps.SmallZoom());
                                
                                ////////////////////////////////////////////////////////
                                
                                
                            };
                        </script>
                        </div>
                    </div>
                    <script>

                        $('.top-about .about-logo, .top-about .datas, .top-about .map').equalHeightColumns();
                    </script>
                    <div class="bottom-about">
                        <div class="content-about">
                            <a href="<?php echo $this->createUrl('/companies/'.$model->company->category->id.'/'.$model->company->id);?>">
                                <h1><?php echo $model->company->title;?></h1>
                            </a>
                            <div class="text">
                                <?php echo $model->company->description;?>
                            </div>
                        </div>
                        <div class="images-about">
                            <?php if($gallery):?>
                                <ul id="pikame">
                                    <?php foreach($gallery as $g):?>
                                        <li>
                                            <a href="/content/companies/<?php echo $g->img;?>"><img src="/content/companies/thumbs/<?php echo $g->thumb;?>"/></a>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                                <script>
                                    $(document).ready(function (){
                                        var a = function(self){
                                            self.anchor.fancybox();
                                        };
                                        $("#pikame").PikaChoose({buildFinished:a, autoPlay:false, showCaption:false, text: {previous: " ", next: " " }});
                                    });
                                </script>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
              </div>

            </div>  <!-- ### end main section -->
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
<script>
    $(document).ready(function(){
        $('#btn-map').click(function(){
            $('.detail-image').hide();
            $('.detail-map').show();
            showMap();
        });
        $('.top-info-logo').click(function(){
            $('.detail-map').hide();
            $('.detail-image').show();
        });
    });
    function showMap () {
        YMaps.load(function() {
            var bigmap = new YMaps.Map(document.getElementById("map"));
            bigmap.setCenter(new YMaps.GeoPoint(<?php echo $coords;?>), 16);
            // Создает метку в центре Москвы
            var placemark = new YMaps.Placemark(new YMaps.GeoPoint(<?php echo $coords;?>));
            // Устанавливает содержимое балуна
            placemark.name = "<?php echo $model->city->name;?>";
            placemark.description = "<?php echo $model->company->address;?>";
            // Добавляет метку на карту
            bigmap.addOverlay(placemark);
            bigmap.addControl(new YMaps.SmallZoom());
        });
    }
</script>
<script>

</script>

