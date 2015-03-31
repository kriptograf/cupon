<div class="item-kupon">
    <div class="item-img">
        <a href="/kupones/<?php echo $data->kupon_id;?>">
            <img src="/content/kupones/<?php echo $data->kupon->image;?>"> <!-- ### сюда картинку -->
        </a>
        <div class="ticket">
            <div class="ticket-percent"><?php echo $data->kupon->tax;?>%</div>
            <div class="ticket-discounts">скидки</div>
            <div class="ticket-date">до <?php echo date('d.m.Y',strtotime($data->kupon->end_date));?></div>
        </div>
    </div>
    <div class="item-title">
        <a href="/kupones/<?php echo $data->kupon->id_kupon;?>"><?php echo Kupons::crop($data->kupon->action,150);?></a>
    </div>
    <div class="item-company">
        <div class="item-logo">
            <div class="valign">
                <img src="/content/companies/logo/<?php echo $data->kupon->company->logo;?>">
            </div>
        </div>
        <div class="item-location">г.<?php echo $data->kupon->city->name;?> <?php echo $data->kupon->company->address;?></div>
    </div>

    <div class="item-info">
        <div class="review"><?php echo $data->kupon->views;?></div> <!-- ### сюда выводить просмотры -->
        <div class="count-comments"><?php echo $data->kupon->countComments;?></div> <!-- ### сюда комменты -->
        <div class="rating">
            <input type="hidden" name="val" value="<?php echo $data->kupon->rating;?>"/>
            <?php
            /*$this->widget('CStarRating',array(
                'id'=>'rating'.$data->id_kupon,
                'name'=>'rating'.$data->id_kupon,
                'maxRating'=>5,
                'allowEmpty' => false,
                'readOnly' => true,
                'value'=> $data->rating,
            )); */
            ?>
        </div>
        <script>
            $(".rating").ajaxComplete(function(event,request, settings){
                $(function(){
                    $('.rating').rating({
                        image: '/images/star.gif',
                        readOnly: true
                    });
                });

            });
        </script>
    </div>

    <div class="prices">

        <div class="old-price"><span class="digit"><?php echo (int)$data->kupon->old_price;?> </span>&nbsp;<span class="currency">р.</span></div>
        <div class="new-price"><?php echo (int)$data->kupon->new_price;?> <span class="currency">р.</span></div>
    </div>
</div><!-- ### end item kupon -->
