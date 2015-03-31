<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 15.05.13
 * Time: 23:55
 * To change this template use File | Settings | File Templates.
 */

class Complain extends CFormModel
{
    public $name;
    public $text;
    public $item;

    public function rules()
    {
        return array(
            array('name, text', 'required'),
            array('item', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>'Ваше имя',
            'text'=>'Сообщение',
            'item'=>'Объявление',
        );
    }
}