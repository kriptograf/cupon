<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SetCityController extends Controller
{
    public function actionView($id)
    {
        $alias = Cities::model()->findByPk($id)->alias;
        /**
         * Устанавливаем глобальную переменную текущего города
         */
        Yii::app()->user->setState('currentCity', $id);

        /**
         * Редиректим на страницу откуда пришел пользователь
         */
        //$this->redirect(Yii::app()->request->urlReferrer);
        $this->redirect('http://'.$alias.'.'.$_SERVER['SERVER_NAME']);
    }
}
