<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 05.03.13
 * Time: 22:55
 * To change this template use File | Settings | File Templates.
 */
$controller = (isset(Yii::app()->controller->module->id))?Yii::app()->controller->module->id:'';
if(!$controller)
{
    $controller = 'kupones';
}
?>
<form action="/<?php echo $controller;?>/search/index" method="post">
    <input type="text" name="query" class="query" placeholder="Пицца">
    <input type="submit" value="" class="search-submit">
</form>