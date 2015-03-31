<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'superценник.ру',
    'language' => 'ru',
    'theme' => 'classic',
    'defaultController' => 'site/index',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.UserModule',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.news.models.News',
        'application.modules.kupones.models.*',
        'application.modules.companies.models.*',
        'application.modules.banner.models.*',
        'application.modules.pages.models.*',
        'application.modules.comments.models.*',
        'application.helpers.*',
        'application.extensions.phaActiveColumn.*',
    ),
    'aliases' => array(
        //If you manually installed it
        'xupload' => 'ext.xupload'
    ),
    'modules' => array(
        'admin',
        'news',
        'companies',
        'kupones',
        'banner',
        'pages',
        'board',
        'comments'=>array(
            //you may override default config for all connecting models
            'defaultModelConfig' => array(
                //Только зарегистрированные пользователи могут оставлять комментарии
                'registeredOnly' => true,
                'useCaptcha' => false,
                //древовидные комментарии
                'allowSubcommenting' => true,
                //отображать комментарии после модерации
                'premoderate' => false,
                //action для добавления комментария
                'postCommentAction' => 'comments/comment/postComment',
                //super user condition(display comment list in admin view and automoderate comments)
                'isSuperuser'=>'false',
                //order direction for comments
                'orderComments'=>'DESC',
            ),
            //the models for commenting
            'commentableModels'=>array(
                //model with individual settings
                'Companies'=>array(
                    'registeredOnly'=>true,
                    'useCaptcha'=>false,
                    'allowSubcommenting'=>true,
                    //config for create link to view model page(page with comments)
                    'pageUrl'=>array(
                        'route'=>'admin/companies/view',
                        'data'=>array('id'=>'id'),
                    ),
                ),
            ),
            //config for user models, which is used in application
            'userConfig'=>array(
                'class'=>'Profile',
                'nameProperty'=>'fio',
                //'class'=>'User',
                //'nameProperty'=>'username',
                //'nameProperty'=>'username',
                //'emailProperty'=>'email',
            ),
        ),
        'user' => array(
            //encrypting method (php hash function)
            'hash' => 'md5',
            //send activation email
            'sendActivationMail' => false,
            //allow access for non-activated users
            'loginNotActiv' => true,
            //activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => true,
            //automatically login from registration
            'autoLogin' => true,
            //registration path
            'registrationUrl' => array('/user/registration'),
            //recovery password path
            'recoveryUrl' => array('/user/recovery'),
            //login form path
            'loginUrl' => array('/user/login'),
            //page after login
            'returnUrl' => array('/user/profile'),
            //page after logout
            'returnLogoutUrl' => '/',
        ),
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'cache' => array(
            'class' => 'system.caching.CFileCache', // используем кэш на файлах
        ),
        /*'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => false,
            ),
        ),*/
        'user' => array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/login'),
        ),
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD',
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            //'class'=>'application.components.UrlManager',
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'companies/<id:\d+>' => 'companies/companies/view',
                'companies/<category:\d+>/<id:\d+>' => 'companies/companies/view',
                'companies/<action:\w+>/<id:\d+>' => 'companies/companies/<action>',
                'companies/<action:\w+>' => 'companies/companies/<action>',
                'category/<id:\d+>' => 'companies/categoriesCompany/index',
                'kupones/<id:\d+>' => 'kupones/kupons/view',
                'kupones/<action:\w+>' => 'kupones/kupons/rate',
                'kupones/<action:\w+>/<id:\d+>' => 'kupones/kupons/category',
                'page/<alias:\w+>' => 'pages/page/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        /*
          'db'=>array(
          'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
          ), */
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=kupon',
            'emulatePrepare' => true,
            'username' => 'mysql',
            'password' => 'mysql',
            'charset' => 'utf8',
            // включаем профайлер
            'enableProfiling'=>true,
            // показываем значения параметров
            'enableParamLogging' => true,
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    // направляем результаты профайлинга в ProfileLogRoute (отображается
                    // внизу страницы)
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    'enabled'=>true,
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'categories' => 'application',
                    'showInFireBug' => true
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);