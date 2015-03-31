<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 05.05.13
 * Time: 14:52
 * To change this template use File | Settings | File Templates.
 */

class SetCountPageController extends Controller
{
    public function actionIndex()
    {
        $referer = Yii::app()->request->getUrlReferrer();

        $cookie_name = 'page_'.Yii::app()->request->getParam('name');

        $param = Yii::app()->request->getParam('id');

        Yii::app()->request->cookies[$cookie_name] = new CHttpCookie($cookie_name, $param);

        $this->redirect($referer);
    }
}