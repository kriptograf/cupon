<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">
                <h3 id="h-s">Результаты поиска по запросу: <span id="s-q"><?php echo CHtml::encode($query);?></span></h3>
                <?php if(!$model):?>
                <p>Ничего не найдено:(</p>
                <?php else:?>
                <?php foreach($model as $item):?>
                    <div class="item-kupon">
                        <div class="item-img">
                            <a href="/kupones/<?php echo $item->id_kupon;?>">
                                <img src="/content/kupones/<?php echo $item->image;?>"> <!-- ### сюда картинку -->
                            </a>
                            <div class="ticket">
                                <div class="ticket-percent"><?php echo $item->tax;?>%</div>
                                <div class="ticket-discounts">скидки</div>
                                <div class="ticket-date">до <?php echo date('d.m.Y',strtotime($item->end_date));?></div>
                            </div>
                        </div>
                        <div class="item-title">
                            <a href="/kupones/<?php echo $item->id_kupon;?>"><?php echo Kupons::crop($item->action, 150); ?></a>
                        </div>
                        <div class="item-company">
                            <div class="item-logo">
                                <div class="valign">
                                    <img src="/content/companies/logo/<?php echo $item->company->logo;?>">
                                </div>
                            </div>
                            <div class="item-location">г.<?php echo $item->city->name;?> <?php echo $item->company->address;?></div>
                        </div>

                        <div class="item-info">
                            <div class="review"><?php echo $item->views;?></div> <!-- ### сюда выводить просмотры -->
                            <div class="count-comments"><?php echo $item->countComments;?></div> <!-- ### сюда комменты -->
                            <div class="rating">
                                <?php
                                $this->widget('CStarRating',array(
                                    'id'=>'rating'.$item->id_kupon,
                                    'name'=>'rating'.$item->id_kupon,
                                    'maxRating'=>5,
                                    'allowEmpty' => false,
                                    'readOnly' => true,
                                    'value'=> $item->rating,
                                ));
                                ?>
                            </div>
                        </div>

                        <div class="prices">

                            <div class="old-price"><span class="digit"><?php echo (int)$item->old_price;?> </span>&nbsp;<span class="currency">р.</span></div>
                            <div class="new-price"><?php echo (int)$item->new_price;?> <span class="currency">р.</span></div>
                        </div>
                    </div><!-- ### end item kupon -->
                <?php endforeach;?>
               <?php endif;?>

            </div>  <!-- ### end main section -->
            <div class="sidebar">
                <ul class="big-nav">
                    <li><a href="<?php echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>
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
