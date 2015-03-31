<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 21.03.13
 * Time: 16:15
 * To change this template use File | Settings | File Templates.
 */
/**
 * добавляем нули вперед
 */
$digit = str_repeat("0", 6-strlen($economy['economy'])).$economy['economy'];
$digit = str_split($digit);
//echo CVarDumper::dump($digit[4], 10, true); exit;
?>
<span class="economy-digits">
    <?php //echo $digit;?>
    <?php foreach($digit as $char):?>
    <div class="dig<?php echo $char;?>"></div>
    <?php endforeach;?>
</span>
<span class="economy-text">Сэкономили для вас сегодня:</span><br>
<span class="economy-currency">рублей</span>