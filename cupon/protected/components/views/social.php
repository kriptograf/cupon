<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 05.04.13
 * Time: 19:52
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="soc-panel">
    <div class="soc-title">Мы в соцсетях:</div>
    <div class="soc-button">
        <?php foreach($buttons as $button):?>
            <a href="<?php echo $button->link;?>" target="_blank" title="<?php echo $button->title;?>">
                <img src="/content/social/<?php echo $button->icon;?>" alt="<?php echo $button->alt;?>" width="32" height="32" />
            </a>
        <?php endforeach;?>
    </div>
</div>