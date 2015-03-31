<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->breadcrumbs=array(
	$model->category->name=>array('/category/'.$model->category->id),
	$model->title,
);
?>

<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
        <div class="main">
            
            <div class="title-companies">
                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                	'separator'=>' / ',
                    'links'=>$this->breadcrumbs,
                    'homeLink'=>CHtml::link('Справочник',Yii::app()->createUrl('/companies')),
                	//'htmlOptions'=>array('class'=>'well well-small'),
                )); ?><!-- breadcrumbs -->
            </div>
            
                
                <div class="company-wrapper">   
                    <div class="company-about">
                        <h2><?php echo $model->title;?></h2>
                    </div>
                    <div class="top-about">
                        <div class="about-logo">
                             <img src="/content/companies/logo/<?php echo $model->logo;?>" />
                        </div>
                        <div class="datas">
                            <div class="address">
                                <?php echo $model->address;?>
                            </div> <br>
                            <div class="phones">
                                <?php
                                $phone = explode(',', $model->phones);
                                foreach($phone as $p)
                                {
                                    echo $p.'<br>';
                                }
                                ?>
                            </div>
                            <br />
                            <div class="schedule">
                                <?php echo $model->schedule;?>
                            </div>
                            <br />
                            <?php if($model->link):?>
                            <div class="link">
                                <?php
                                if(!substr_count($model->link,'http://',0,7))
                                {
                                    $model->link = 'http://'.$model->link;
                                }
                                ?>
                                <?php echo CHtml::link(CHtml::encode(str_replace('http://','',$model->link)), $model->link, array('target'=>'_blank')); ?>
                            </div>
                            <?php endif;?>
                        </div>
                        <?php if($model->x && $model->y):?>
                            <?php $coords = $model->x.','.$model->y;?>
                        <?php else:?>
                            <?php
                            $url = 'http://geocode-maps.yandex.ru/1.x/?geocode='.urlencode(str_replace("\r\n",' ',$model->address));
                            $result = file_get_contents($url);
                            $xml = simplexml_load_string($result);
                            $coords = (string)$xml->GeoObjectCollection->featureMember->GeoObject->Point->pos;
                            $coords = str_replace(' ', ',', $coords);
                            ?>
                        <?php endif;?>
                        <div class="map">
                            <div id="map" style="width: 270px;margin-left: 5px; margin-top: 2px;"></div>
                            
                        </div>
                        <script type="text/javascript">
                            $(window).load(function(){

                                $('.top-about .about-logo, .top-about .datas, .top-about .map, .top-about .map #map').equalHeightColumns();
                            });
                        </script>
                        <script type="text/javascript">
                            window.onload = function () {
                                var map = new YMaps.Map(document.getElementById("map"));
                                map.setCenter(new YMaps.GeoPoint(<?php echo $coords;?>), 15);
                                // Создает метку в центре Москвы
                                var placemark = new YMaps.Placemark(new YMaps.GeoPoint(<?php echo $coords;?>));
                                // Устанавливает содержимое балуна
                                placemark.name = "<?php echo $model->city->name;?>";
                                placemark.description = "<?php echo str_replace("\r\n",' ',$model->address);?>";
                                // Добавляет метку на карту
                                map.addOverlay(placemark);
                                map.addControl(new YMaps.SmallZoom());
                            };
                        </script>
                    </div>
                    
                    <!-- ##############################################################-->

                    <div class="grayscale">
                        <div class="company-rating">
                            <div style="float: left;">Народный рейтинг<br />
                            <?php
                                        $this->widget('CStarRating',array(
                                            'name'=>'rating',
                                            'maxRating'=>5,
                                            'cssFile'=>'/css/rating/jquery.myrating.css',
                                            'allowEmpty' => false,
                                            'readOnly' => (Yii::app()->request->cookies['company_'.$model->id]->value)?true:false,
                                            'value'=> $model->rating,
                                            'callback'=>'function(){
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "'.Yii::app()->createUrl('companies/rating').'",
                                                                data: "id='.$model->id.'&rate=" + $(this).val(),
                                                                dataType : "json",
                                                                success: function(msg){
                                                                    alert(msg.msg);
                                                                    $("#rating > input").rating("readOnly", true);
                                                                    $("#voters").html(msg.voters);
                                                                    $("#vote").html(msg.rating);
                                                                }
                                                            })
                                                        }',
                                        ));
                                    ?>
                                </div>
                            <div id="rating-info">
                                <p>Голосов: <span id="voters"><?php echo $model->voters;?></span></p>
                                <p>Средний балл: <span id="vote"><?php echo $model->rating;?></span></p>
                            </div>
                        </div>
                        <div class="vid">
                            <span class="review"><?php echo $model->views;?></span>
                            <span class="count-comments"><?php echo $model->commentsCount;?></span>
                        </div>
                    </div>
                    <div class="bottom-about">
                         <div class="content-about">
                             <h1>О компании</h1>
                             <div class="text">
                                 <?php echo $model->description;?>
                             </div>
                         </div>
                        <div class="images-about">
                            <div class="video">
                                <div id="youtube">
                                    <?php echo $model->video;?>
                                </div>
                            </div>
                            <div style="height: 20px;"></div>
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
                                    $("#pikame").PikaChoose({buildFinished:a, autoPlay:true, speed:5000, showCaption:false, text: {previous: " ", next: " " }});
                                });
                            </script>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php if($model->newsCompany):?>
                    <div class="bottom-about">
                        <div class="content-news">
                             <h1>Новости</h1>
                             <div class="list-news">
                                 <?php foreach ($model->newsCompany as $news):?>
                                 <div class="news-item">
                                     <div class="news-date">
                                         <?php echo date('d.m.Y',$news->date);?>
                                     </div>
                                     <div class="news-text">
                                         <?php echo $news->text;?>
                                     </div>
                                 </div>
                                 <?php endforeach;?>
                             </div>
                         </div>
                    </div>
                    <?php endif;?>
                    <!-- ####### модуль комментариев ####-->
                    <div class="bottom-about">
                        <div class="content-news">
                             <h1>Отзывы</h1>
                            <?php
                            $this->widget('comments.widgets.ECommentsListWidget', array(
                                'model' => $model,
                            ));?>
                        </div>
                    </div>         
                    <!-- ####### модуль комментариев ####-->
                </div>
        </div>  <!-- ### end main section -->
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

        </div>  <!-- ### end sidebar section -->
        </div>

    </div>
</div>







