<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $settings = '';

    /**
     * Имя кеша для случайной выборки купонов
     * @var string
     */
    public $randNumber = 1;

    /**
     * Массив идентиыикаторов
     * @var null
     */
    public $identifiers = null;



    public function init()
    {
        $this->settings = Settings::model()->find();
        $this->pageTitle = $this->settings->title;

        /**
         * Имя кеша для этого пользователя.
         */
        $cacheName = md5(Yii::app()->request->userHostAddress);
        /**
         * Получаем из кеша случайное число для рандомной выборки
         * Если вернулся false потребуется создать кеш
         */
        $this->randNumber = Yii::app()->cache->get($cacheName);

        if (!$this->randNumber)
        {
            $results = Kupons::model()->count();

            $digit = rand(1, $results);

            /**
             * храним значение переменной в кэше не более 30 секунд
             */
            Yii::app()->cache->set($cacheName, $digit, 600);

            /**
             * Получаем идентификаторы из кеша
             */
            $this->randNumber = Yii::app()->cache->get($cacheName);
        }
    }

    /**
     * расширяем конструктор класса и добавляем город для приложения
     * город приложения будет установлен явно на каждый запрос.
     *
     * @param type $id
     * @param type $module
     */
    /*public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        // Если есть post-запрос, перенаправить приложение на адрес с выбранным языком
        if (isset($_POST['city']))
        {
            //Получаем код языка из пост запроса
            $city = $_POST['city'];
            //Формирование returnUrl
            $CityReturnUrl = $_POST[$city];
            $this->redirect($CityReturnUrl);
        }
        // Установить город приложения если предоставлен GET, сессии или куки
        if (isset($_GET['city']))
        {
            //Если вместо языка передано черт знает что, ставим язык по умолчанию
//                if(!preg_match('/[a-z]{2}/', $_GET['language']))
//                {
//                    $_GET['language'] = 'en';
//                }

            //Устанавливаем город в сессию
            Yii::app()->user->setState('city', $_GET['city']);
            //Устанавливаем язык в куку
            $cookie = new CHttpCookie('city', $_GET['city']);
            //Устанавливаем время жизни куки 1 год
            $cookie->expire = time() + (60 * 60 * 24 * 365);
            Yii::app()->request->cookies['city'] = $cookie;
        }


    }*/

    /**
     * Формирование url с параметром города
     * @param string $lang
     * @return string
     */
    /*public function createCityReturnUrl($city = '1')
    {
        if (count($_GET) > 0)
        {
            $arr = $_GET;
            $arr['city'] = $city;
        }
        else
        {
            $arr = array('city' => $city);
        }

        return $this->createUrl('', $arr);
    }*/

}