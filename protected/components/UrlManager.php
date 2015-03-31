<?php
/**
 * Перегруженный класс UrlManager
 * Добавлена возможность подставления в url кода города
 * Переопределен метод creteUrl()
 */
class UrlManager extends CUrlManager
{
    public $languages;
    public $langParam;

    /**
     * Переопределенный метод класса CUrlManager
     * @param string $route
     * @param array $params
     * @param string $ampersand
     * @return string
     */
    public function createUrl($route,$params=array(),$ampersand='&')
    {
        /**
         * Если в параметрах нет города
         */
        if (!isset($params['city']))
        {
            /**
             * Если в сессии есть элемент city, устанавливаем
             * город приложения
             * из сессии
             */
            if (Yii::app()->user->hasState('city'))
            {
                $params['city'] = Yii::app()->user->getState('city');
            }  
            /**
             * Если есть в куках елемент city, берем язык приложения из куки
             */
            else if(isset(Yii::app()->request->cookies['city']))
            {
                $params['city'] = Yii::app()->request->cookies['city']->value;
            }
            else
            {
                /**
                 * Берем город приложения из конфига
                 */
                $params['city'] = 1;
            }

        }
        
        return parent::createUrl($route, $params, $ampersand);
    }

}
