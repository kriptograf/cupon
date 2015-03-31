<?php

class DefaultController extends Controller
{
    

    /**
     * Override layout to backend
     * @var string
     */
    public $layout = '//layouts/admincolumn2';

	public function actionIndex()
	{
            if(!UserModule::isAdmin()||Yii::app()->user->isGuest)
            {
                $this->redirect('/admin/login');
            }
            
            $model=new KuponsActive('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['KuponsActive']))
                    $model->attributes=$_GET['KuponsActive'];

            $this->render('index',array(
                    'model'=>$model,
            ));
	}
        /**
     * Массовое удаление записей
     * @throws CHttpException
     */
    public function actionGroupDelete()
    {
        if(isset($_POST))
        {
            $items = $_POST['group-checkbox-column'];
            if($items)
            {
                $model= KuponsActive::model();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('id', $items);
                if($model->deleteAll($criteria))
                {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
                else
                {
                    throw new CHttpException(400,'Invalid request. DataBase error.');
                }
            }
            else
            {
                throw new CHttpException(400,'Вы не выбрали записи для удаления.');
            }
        }
        else
        {
            throw new CHttpException(400,'Вы пытаетесь обмануть судьбу!');
        }

    }
    
    /**
     * Переключатель статуса ajax
     * @param $id
     * @param $attribute
     * @throws CHttpException
     */
    public function actionToggle($id, $attribute)
    {
        if (!in_array($attribute, array('status')))
            throw new CHttpException(400, 'Некорректный запрос');

        $model = $this->loadModel($id);
        $model->$attribute = $model->$attribute ? 0 : 1;
        if(!$model->save())
        {
            echo CVarDumper::dump($model->getErrors(),10,true);exit;
        }

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }
    
    public function loadModel($id)
    {
            $model=  KuponsActive::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
            return $model;
    }

}