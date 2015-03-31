<?php

class SiteController extends Controller
{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }



    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        /**
         * Макет по умолчанию
         */
        $this->layout = '//layouts/column2';


        //echo CVarDumper::dump($this->randNumber,10,true);


        $catKupones = CategoriesKupon::model()->findAll('1 ORDER BY name');

        //количество записей на странице
        $pageSize = '15';
        $cookie = (isset(Yii::app()->request->cookies['page_site']->value))?Yii::app()->request->cookies['page_site']->value:'';
        if($cookie)
        {
            $pageSize = $cookie;
        }

        $criteria = new CDbCriteria();
        $criteria->compare('t.city_id', Yii::app()->user->getState('currentCity',1));
        $criteria->compare('t.status',1);
        $criteria->with=array('company'=>array('company.checked'=>1));
        $criteria->compare('company.checked',1);


        $total = Kupons::model()->count($criteria);

        $pages = new CPagination($total);
        $pages->pageSize = $pageSize;
        $pages->applyLimit($criteria);

        $this->render('index', array(
            'catKupones' => $catKupones,
            'dataProvider' => new CActiveDataProvider('Kupons', array(
                'criteria' => array(
                    'with'   => array('company'=>array('company.checked'=>1)),
                    'condition' => 't.city_id='.Yii::app()->user->getState('currentCity',1).' AND company.checked=1 AND t.status=1',
                    'order' => 'RAND(' . $this->randNumber . ')',
                ),
                'pagination' => array(
                    'pageSize' => $pageSize,
                ),
           )),
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error)
        {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $contacts = Pages::model()->findByAttributes(array('alias' => 'contacts'));
        $catKupones = CategoriesKupon::model()->findAll();

        $model = new ContactForm;
        if (isset($_POST['ContactForm']))
        {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate())
            {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array(
            'model' => $model,
            'contacts' => $contacts,
            'categories' => $catKupones,
        ));
    }

}