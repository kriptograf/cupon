<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
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

    <?php if(Yii::app()->user->hasFlash('message')):?>
        <script>
            alert("<?php echo Yii::app()->user->getFlash('message');?>")
        </script>
    <?php endif;?>
    <div class="company-wrapper edit-wrap">
        <div class="company-about">
            <h2><?php echo $model->title;?> - Редактирование</h2>
        </div>
        <div class="top-about">
            <div class="about-logo">
                <img width="100" src="/content/companies/logo/<?php echo $model->logo;?>" />
                <?php echo CHtml::form('/companies/updateLogo/'.$model->id,'post', array('enctype' => 'multipart/form-data'));?>
                    <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                    <?php echo CHtml::activeFileField($model,'logo');?>
                    <?php echo CHtml::submitButton('Сохранить',array(
                        'id'=>'logo-submit',
                        'class'=>'btn',
                    ));?>
                <?php echo CHtml::endForm();?>
            </div>
            <div class="datas">
                <div class="address">
                    <?php echo $model->city->name;?> <?php //echo $model->address;?>
                    <?php echo CHtml::form('/companies/updateAddress/'.$model->id,'post');?>
                    <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                    <?php echo CHtml::activeTextField($model,'address', array('value'=>$model->address));?>
                    <?php echo CHtml::submitButton('Сохранить',array(
                        'id'=>'address-submit',
                        'class'=>'btn'
                    ));?>
                    <?php echo CHtml::endForm();?>
                </div> <br>
                <div class="phones">
                    <?php
                    /*$phone = explode(',', $model->phones);
                    foreach($phone as $p)
                    {
                        echo $p.'<br>';
                    }*/
                    ?>
                    <?php echo CHtml::form('/companies/updatePhones/'.$model->id,'post');?>
                    <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                    <?php echo CHtml::activeTextField($model,'phones', array('value'=>$model->phones));?>
                    <?php echo CHtml::submitButton('Сохранить',array(
                        'id'=>'phones-submit',
                        'class'=>'btn'
                    ));?>
                    <?php echo CHtml::endForm();?>
                </div>
                <br />
                <div class="schedule">
                    <?php //echo $model->schedule;?>
                    <?php echo CHtml::form('/companies/updateSchedule/'.$model->id,'post');?>
                    <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                    <?php echo CHtml::activeTextField($model,'schedule', array('value'=>$model->schedule));?>
                    <?php echo CHtml::submitButton('Сохранить',array('id'=>'schedule-submit','class'=>'btn'));?>
                    <?php echo CHtml::endForm();?>
                </div>
                <br />
                <?php //if($model->link):?>
                    <div class="link">
                        <a href="<?php echo $model->link;?>"><?php echo $model->link;?></a>
                        <?php echo CHtml::form('/companies/updateLink/'.$model->id,'post');?>
                        <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                        <?php echo CHtml::activeTextField($model,'link', array('value'=>$model->link));?>
                        <?php echo CHtml::submitButton('Сохранить',array('id'=>'link-submit','class'=>'btn'));?>
                        <?php echo CHtml::endForm();?>
                    </div>
                <?php //endif;?>
            </div>

            <?php
            $url = 'http://geocode-maps.yandex.ru/1.x/?geocode='.urlencode($model->city->name.' '.$model->address);
            $result = file_get_contents($url);
            $xml = simplexml_load_string($result);
            $coords = (string)$xml->GeoObjectCollection->featureMember->GeoObject->Point->pos;
            $coords = str_replace(' ', ',', $coords);
            ?>

            <div class="map">
                <div id="map" style="width: 270px;margin-left: 5px; margin-top: 2px;">
                    <!--                                <img src="#" id="static-map" />-->
                </div>

            </div>
            <script type="text/javascript">
                $(window).load(function(){

                    $('.top-about .about-logo, .top-about .datas, .top-about .map, .top-about .map #map').equalHeightColumns();

//                                var height = $('.map').height();
//
//                                var newsrc = "http://static-maps.yandex.ru/1.x/?ll=<?php echo $coords;?>&size=270,"+height+"&z=14&l=map&pt=<?php echo $coords;?>,flag";
//
//                                var img = document.getElementById('static-map');
//
//                                img.src = newsrc;



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
                    placemark.description = "<?php echo $model->address;?>";
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
                        'readOnly' => Yii::app()->request->cookies['companies_'.$model->id]->value,//Yii::app()->user->isGuest || ,
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
                    <?php //echo $model->description;?>
                    <?php echo CHtml::form('/companies/updateDescription/'.$model->id,'post');?>
                    <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                    <?php echo CHtml::activeTextArea($model,'description', array('value'=>$model->description,'cols'=>50, 'rows'=>20));?>
                    <br>
                    <?php echo CHtml::submitButton('Сохранить',array('id'=>'description-submit','class'=>'btn'));?>
                    <?php echo CHtml::endForm();?>
                </div>
            </div>

            <div class="images-about">
                <div class="video">
                    <div id="youtube">
                        <?php echo $model->video;?>
                    </div>
                    <?php echo CHtml::form('/companies/updateVideo/'.$model->id,'post');?>
                    <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                    <?php echo CHtml::activeTextField($model,'video', array('value'=>$model->video,'style'=>'width:270px;'));?>
                    <?php echo CHtml::submitButton('Сохранить',array('id'=>'video-submit','class'=>'btn'));?>
                    <?php echo CHtml::endForm();?>
                </div>
                <?php if($gallery):?>
                    <ul class="list-gall">
                        <?php $count = count($gallery); $count = 4-$count;?>
                        <?php foreach($gallery as $g):?>
                            <li>
                                <img src="/content/companies/thumbs/<?php echo $g->thumb;?>" width="50"/>
                                <?php echo CHtml::form('/companies/updateGallery/'.$g->id,'post',array('class'=>'gall','enctype' => 'multipart/form-data'));?>
                                <?php echo CHtml::activeHiddenField(new Gallery(),'id',array('value'=>$g->id));?>
                                <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                                <?php echo CHtml::activeFileField(new Gallery(),'files', array('size'=>'15'));?>
                                <?php echo CHtml::submitButton('Сохранить',array('id'=>'files-submit','class'=>'btn'));?>
                                <?php echo CHtml::endForm();?>
                            </li>
                        <?php endforeach;?>
                        <?php for($i=0;$i<$count;$i++):?>
                        <li>
                            <?php echo CHtml::form('/companies/updateGallery/'.$model->id,'post',array('enctype' => 'multipart/form-data'));?>
                            <?php echo CHtml::activeHiddenField(new Gallery(),'id');?>
                            <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                            <?php echo CHtml::activeFileField(new Gallery(),'files', array('size'=>29));?>
                            <?php echo CHtml::submitButton('Сохранить',array('id'=>'files-submit','class'=>'btn'));?>
                            <?php echo CHtml::endForm();?>
                        </li>
                        <?php endfor;?>
                    </ul>
                <?php endif;?>
            </div>
        </div>
        <?php if($model->newsCompany):?>
            <div class="bottom-about">
                <div class="content-news">
                    <h1>Новости</h1>
                    <div class="list-news">
                        <?php $j=5; $count = count($model->newsCompany); $count = 4-$count;?>
                        <?php foreach ($model->newsCompany as $news):?>
                            <div class="news-item">

                                <div class="news-text">
                                    <?php echo CHtml::form('/companies/updateNews/'.$model->id,'post');?>
                                    <div class="news-date">
                                        <?php echo date('d.m.Y',$news->date);?>
                                        <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'id'=>'NewsCompany_date_'.$j,
                                            'model'=>$news, //модель
                                            'attribute'=>'date', //атрибут модели
                                            'language'=>'ru', //язык локализации виджета
                                            // дополнительные опции - такие же как JQuery UI Datepicker
                                            'options'=>array(
                                                'showAnim'=>'fold',
                                                'showOn'=>'button',
                                                'buttonImage'=>'/images/admin/edit.png',
                                                'dateFormat'=>'dd-mm-yy',

                                            ),
                                            'htmlOptions'=>array(
                                                'class'=>'datepicker',
                                                'title'=>'Выбрать дату',
                                            ),
                                        ));
                                        ?>
                                    </div>

                                    <?php echo CHtml::activeHiddenField(new NewsCompany(),'id',array('value'=>$news->id));?>
                                    <?php echo CHtml::activeHiddenField($model,'id',array('value'=>$model->id));?>
                                    <?php echo CHtml::activeTextField(new NewsCompany(),'text', array('value'=>$news->text,'class'=>'NewsCompany_text'));?>
                                    <?php echo CHtml::submitButton('Сохранить',array('id'=>'news-submit','class'=>'btn'));?>
                                    <?php echo CHtml::endForm();?>
                                </div>
                            </div>
                            <?php $j++;?>
                        <?php endforeach;?>
                        <?php for($i=0;$i<$count;$i++):?>
                            <div class="news-item">
                                <div class="news-date">
                                    <?php //echo date('d.m.Y',$news->date);?>
                                </div>
                                <div class="news-text">
                                    <?php echo CHtml::form('/companies/updateNews/'.$model->id,'post');?>
                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'id'=>'NewsCompany_date'.$i,
                                        'model'=>new NewsCompany(), //модель
                                        'attribute'=>'date', //атрибут модели
                                        'language'=>'ru', //язык локализации виджета
                                        // дополнительные опции - такие же как JQuery UI Datepicker
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'showOn'=>'button',
                                            'buttonImage'=>'/images/calendar.gif',
                                            'dateFormat'=>'dd-mm-yy',

                                        ),
                                        'htmlOptions'=>array(
                                            'class'=>'datepicker',
                                            'title'=>'Выбрать дату',
                                        ),
                                    ));
                                    ?>
                                    <?php echo CHtml::activeHiddenField(new NewsCompany(),'id');?>
                                    <?php echo CHtml::activeHiddenField($model,'id');?>
                                    <br>
                                    <?php echo CHtml::activeTextField(new NewsCompany(),'text', array('class'=>'NewsCompany_text'));?>
                                    <?php echo CHtml::submitButton('Сохранить',array('id'=>'news-submit','class'=>'btn'));?>
                                    <?php echo CHtml::endForm();?>
                                </div>
                            </div>
                        <?php endfor;?>
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
    <!--            <ul class="right-menu">
                <?php //foreach($categories as $category):?>
                <li><a href="<?php //echo Yii::app()->createUrl('/category/'.$category->id);?>"><?php //echo $category->name;?> <span class="count-cat"><?php //echo $category->countCompanies; ?></span></a></li>
                <?php //endforeach;?>
            </ul>-->
</div>  <!-- ### end sidebar section -->
</div>

</div>
</div>

