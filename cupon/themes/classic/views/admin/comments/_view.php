<?php
/* @var $this CommentsController */
/* @var $data Comments */
?>
<div class="comment">
    <!--<div class="avatar">-->
        <!--<img src="http://www.gravatar.com/avatar/<?php //echo md5($data->user->email);?>?size=50" />-->
    <!--</div>-->

    <div class="name"><?php echo $data->user->profile->fio;?></div>
    <div class="date"><?php echo CHtml::encode(date('d.m.Y',strtotime($data->date))); ?></div>
    <p><?php echo CHtml::encode($data->content); ?></p>
</div>