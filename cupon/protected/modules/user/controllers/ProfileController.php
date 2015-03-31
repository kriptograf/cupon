<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
            $model = $this->loadUser();
            
            $catKupones = CategoriesKupon::model()->findAll();
            
            $mykupons = new CActiveDataProvider('UsersKupons', array(
                'criteria' => array(
                    'condition' => 'user_id='.Yii::app()->user->id,
                ),
//                'pagination' => array(
//                    'pageSize' => 6,
//                ),
           ));
            //$mykupons = UsersKupons::model()->findAllByAttributes(array('user_id'=>  Yii::app()->user->id));
            
	    $this->render('profile',array(
	    	'model'=>$model,
		'profile'=>$model->profile,
                'catKupones' => $catKupones,
                'mykupons'=>$mykupons,
	    ));
	}
        
        public function actionMyCompanies()
        {
            //$categories = CategoriesCompany::model()->findByPk($id);//CategoriesCompany::model()->findAll();

            $dataProvider=new CActiveDataProvider('Companies', array(
                'criteria'=>array(
                    'condition'=>'user_id='.Yii::app()->user->id,
                ),
            ));
            $this->render('myCompanies',array(
                    'dataProvider'=>$dataProvider,
                    //'categories'=>$categories,
            ));
        }

                /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile = $model->profile;
                
                $catKupones = CategoriesKupon::model()->findAll();
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

            $model->username = $model->email;
                        
			$profile->attributes = $_POST['Profile'];


            if($_POST['Profile']['hideen_foto']=='')
            {
                /**
                 * Если есть загруженное лготип сохраняем его здесь с помощью модели
                 */
                $profile->photo = CUploadedFile::getInstance($profile, 'photo');
                if ($profile->photo)
                {
                    if ($profile->photo->saveAs(Yii::getPathOfAlias('webroot') . '/content/profiles/photo/' . $profile->photo))
                    {

                        //Если изображение сохранено в указанной директории
                        //Обрабатываем его, создаем эскизы(небольшие изображения)
                        //Создаем экземпляр класса Image(расширение) и передаем ему имя файла для обработки
                        $thumbs = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . '/content/profiles/photo/' . $profile->photo);
                        //Изменяем размер исходного изображения
                        $thumbs->resize(100, 100, 2);
                        //Сохраняем изображение с новым именем в новую директорию
                        $thumbs->save(Yii::getPathOfAlias('webroot') . '/content/profiles/avatars/' . $profile->photo);

                        $profile->photo = $profile->photo->name;
                    }

                }
            }
            else
            {
                $profile->photo=$_POST['Profile']['hideen_foto'];
            }

                       
			if($model->validate()&&$profile->validate()) 
            {
                //echo CVarDumper::dump($profile->attributes,10,true);exit;
				$model->save();
				if($profile->save())
                {
                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('profileMessage',UserModule::t("Изменения сохранены."));
                    $this->redirect(array('/user/profile'));
                }
                else
                {
                    echo CVarDumper::dump($profile->getErrors(),10,true);
                }
			} 
            else
            {
                $profile->validate();
            }
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
                        'catKupones' => $catKupones,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
                
                $catKupones = CategoriesKupon::model()->findAll();
                
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model,'catKupones' => $catKupones,));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}