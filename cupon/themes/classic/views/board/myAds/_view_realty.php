<?php
/* @var $this MyAdsController */
/* @var $data Ads */
?>
<div class="ads-view">
    <!--<input type="checkbox" class="cbox" name="bulk[]" value="<?php //echo $data->id;?>">-->
    <div class="img">
        <?php if($data->realtyImg):?>
        <img src="<?php echo $data->realtyImg[0]->thumb;?>" alt="<?php echo $data->title;?>">
        <?php endif;?>
    </div>
    <div class="ads-info">
        <span class="ads-title"><?php echo $data->title;?></span><br>
        <span class="ads-views"><?php echo $data->views;?> просмотров</span>
    </div>
    <div class="ads-detail">
        <?php echo Kupons::crop($data->details,300);?>
    </div>
    <div class="ads-price">
        <strong><?php echo $data->price;?></strong> руб.
    </div>

    <div class="ads-manage">
        <?php if($data->status == 1):?>
        <div class="ads-date-pub">
            <span class="ads-date">Публикация до <?php echo date('d.m.Y',$data->date_end);?></span>
        </div>
        <?php else:?>
            <div class="ads-date-unpub">
                <span class="ads-dates">Публикация до <?php echo date('d.m.Y',$data->date_end);?></span>
            </div>
        <?php endif;?>
        <div class="btn-manage">
            <a class="btn-prolong" href="/board/myAds/prolong/id/<?php echo $data->id;?>/section/realty">
                <span>Продлить</span>
            </a>
            <a class="btn-preview" href="/board/myAds/view/id/<?php echo $data->id;?>/section/realty">
                <span>Просмотр</span>
            </a>
            <a class="btn-edit" href="/board/myAds/edit/id/<?php echo $data->id;?>/section/realty">
                <span>Редактировать</span>
            </a>
            <a class="btn-del" href="/board/myAds/delete/id/<?php echo $data->id;?>/section/realty">
                <span>Удалить</span>
            </a>
        </div>
    </div>
</div>