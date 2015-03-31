<div class="count-record">
    Выводить по:
    <a class="<?php echo ($count_records==10)?'active':''?>" href="/setCountPage/index/id/10/name/<?php echo Yii::app()->controller->module->id;?>">10</a>
    <a class="<?php echo ($count_records==20)?'active':''?>" href="/setCountPage/index/id/20/name/<?php echo Yii::app()->controller->module->id;?>">20</a>
    <a class="<?php echo ($count_records==30)?'active':''?>" href="/setCountPage/index/id/30/name/<?php echo Yii::app()->controller->module->id;?>">30</a>
</div>