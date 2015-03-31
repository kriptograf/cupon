<?php

class ActivatedController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/admincolumn2';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new KuponsActive;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['KuponsActive']))
        {
            $model->attributes = $_POST['KuponsActive'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['KuponsActive']))
        {
            $model->attributes = $_POST['KuponsActive'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('KuponsActive');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Массовое удаление записей
     * @throws CHttpException
     */
    public function actionGroupDelete()
    {
        if (isset($_POST))
        {
            $items = $_POST['group-checkbox-column'];
            if ($items)
            {
                $model = KuponsActive::model();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('id', $items);
                if ($model->deleteAll($criteria))
                {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
                else
                {
                    throw new CHttpException(400, 'Invalid request. DataBase error.');
                }
            }
            else
            {
                throw new CHttpException(400, 'Вы не выбрали записи для удаления.');
            }
        }
        else
        {
            throw new CHttpException(400, 'Вы пытаетесь обмануть судьбу!');
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
        if (!$model->save())
        {
            echo CVarDumper::dump($model->getErrors(), 10, true);
            exit;
        }

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new KuponsActive('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['KuponsActive']))
            $model->attributes = $_GET['KuponsActive'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return KuponsActive the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = KuponsActive::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param KuponsActive $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'kupons-active-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
