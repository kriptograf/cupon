<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

    public function actionForm()
    {
        $model=new UserLogin;

        echo $this->renderPartial('/user/ajaxlogin',array('model'=>$model),false,true);
        Yii::app()->end();
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest)
        {

			$model=new UserLogin;

            // ajax validator
            if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
            {
                echo UActiveForm::validate(array($model));
                Yii::app()->end();
            }

            if (Yii::app()->user->id)
            {
                //$this->redirect(Yii::app()->controller->module->profileUrl);
                $this->redirect(Yii::app()->user->returnUrl);
            }
            else
            {
                if(isset($_POST['UserLogin']))
                {
                    $model->attributes=$_POST['UserLogin'];
                    // validate user input and redirect to previous page if valid
                    if($model->validate())
                    {
                        $_SESSION['ok']=1;
                        $this->lastViset();
                        if (Yii::app()->user->returnUrl=='/index.php')
                        {
                            //$this->redirect(Yii::app()->homeUrl);
                            echo '<script>window.location.href = "'.Yii::app()->request->getUrlReferrer().'";</script>';exit;
                        }
                        else
                        {
                            //$this->redirect(Yii::app()->homeUrl);
                            echo '<script>window.location.href = "'.Yii::app()->request->getUrlReferrer().'";</script>';exit;
                        }

                    }
                    else
                    {
                        $error = $model->getErrors();
                        echo '<script>
                        alert("'.$error['username'][0].' '.$error['password'][0].' '.$error['status'][0].'")
                        </script>';
                        exit;
                    }
                }
            }
			// collect user input data
            if(Yii::app()->request->isAjaxRequest)
            {
                // display the ajax login form
                $this->render('/user/ajaxlogin',array('model'=>$model));
            }
            else
            {
                // display the login form
                $this->render('/user/login',array('model'=>$model));
            }

		}
        else
        {
            $this->redirect(Yii::app()->controller->module->returnUrl);
        }

	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}