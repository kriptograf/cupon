<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 03.04.13
 * Time: 11:31
 * To change this template use File | Settings | File Templates.
 */
class LoginController extends Controller
{
    public $layout = '//layouts/adminlogin';

    public $defaultAction = 'login';

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest)
        {
            Yii::import('application.modules.user.models.UserLogin');
            $model = new UserLogin();
            // collect user input data
            if(isset($_POST['UserLogin']))
            {
                $model->attributes=$_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if($model->validate())
                {
                    Yii::app()->user->setState('currentCity', $_POST['Cities']['id_city']);
                    $_SESSION['ok']=1;
                    $this->lastViset();

                    $this->redirect('/admin');
                }
            }
            $cities = Cities::model()->findAll();
            // display the login form
            $this->render('login',array('model'=>$model, 'cities'=>$cities));
        }
        else
        {
            $this->redirect('/');
        }

    }

    private function lastViset() {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

}