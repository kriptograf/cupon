<?php
/* @var $this RealtyController */
/* @var $data Realty */
?>
<a class="reaty-item-link" href="/board/realty/view/id/<?php echo $data->id;?>" >
<div class="ads-view">
    <div class="img">
        <?php if($data->realtyImg):?>
            <img src="<?php echo $data->realtyImg[0]->thumb;?>" alt="<?php echo $data->title;?>">
        <?php endif;?>
    </div>
    <div class="ads-info">
        <span class="ads-date"><?php echo date('d.m.Y',$data->date_pub);?></span><br>
        <span class="ads-title1"><?php echo ($data->rooms)?$data->rooms.' комн. ':'';?> </span> <span class="ads-title1"><?php echo $data->area;?> кв.м.</span><br>
        <span class="ads-title1"><?php echo $data->address;?></span>
        <span class="ads-title1">г.<?php echo $data->city->name;?></span><br>
        <span class="ads-views"><?php echo $data->views;?> просмотров</span>
    </div>
    <div class="ads-detail">

        <?php echo $data->title;;?>

    </div>
    <div class="ads-price">
        <strong><?php echo $data->price;?></strong> руб.
    </div>
</div>
</a>