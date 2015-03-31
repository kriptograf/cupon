<?php
/* @var $this AdsController */
/* @var $data Ads */
?>

<div class="ads-view">
    <div class="img">
        <?php if($data->adsImgs):?>
        <img src="<?php echo $data->adsImgs[0]->thumb;?>" alt="<?php echo $data->title;?>">
        <?php endif;?>
    </div>
    <div class="ads-info">
        <span class="ads-date"><?php echo date('d.m.Y',$data->date_pub);?></span><br>
        <span class="ads-title"><a href="/board/ads/view/id/<?php echo $data->id;?>" ><?php echo $data->title;?></a></span><br>
        <span class="ads-views"><?php echo $data->views;?> просмотров</span>
    </div>
    <div class="ads-detail">
        <?php echo Kupons::crop($data->details,300);?>
    </div>
    <div class="ads-price">
        <strong><?php echo $data->price;?></strong> руб.
    </div>
</div>