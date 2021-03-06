<?php
/**
* Comment controller class file.
*
* @author Dmitry Zasjadko <segoddnja@gmail.com>
* @link https://github.com/segoddnja/ECommentable
* @version 1.0
* @package Comments module
* 
*/
class CommentController extends Controller
{
        public $defaultAction = 'admin';
    
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admincolumn2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
                        'ajaxOnly + PostComment, Delete, Approve',
		);
	}
        
        /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
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
			array('allow',
				'actions'=>array('postComment', 'captcha'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('admin', 'delete', 'approve'),
                'expression' => Yii::app()->getModule('comments')->isAdminExpr,
			),
			array('allow',
				'actions'=>array('admin', 'delete', 'approve','update','groupDelete'),
				'users'=>UserModule::getAdmins(),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Deletes a particular model.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// we only allow deletion via POST request
                $result = array('deletedID' => $id);
                //if($this->loadModel($id)->setDeleted())
                if($this->loadModel($id)->delete())
                    $result['code'] = 'success';
                else 
                    $result['code'] = 'fail';
                echo CJSON::encode($result);
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
                $model = Comment::model();
                $criteria = new CDbCriteria();
                $criteria->addInCondition('comment_id', $items);
                if ($model->deleteAll($criteria))
                {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
	 * Approves a particular model.
	 * @param integer $id the ID of the model to be approve
	 */
	public function actionApprove($id)
	{
		// we only allow deletion via POST request
                $result = array('approvedID' => $id);
                if($this->loadModel($id)->setApproved())
                    $result['code'] = 'success';
                else 
                    $result['code'] = 'fail';
                echo CJSON::encode($result);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Comment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comment']))
			$model->attributes=$_GET['Comment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Comment']))
        {
            $model->attributes=$_POST['Comment'];
            if($model->save())
            {
                $this->redirect(array('admin'));
            }

        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionPostComment()
    {
            if(isset($_POST['Comment']) && Yii::app()->request->isAjaxRequest)
            {
                $comment = new Comment();
                
                //echo CVarDumper::dump($_POST,10,true);
                
                $comment->attributes = $_POST['Comment'];

                if($comment->parent_comment_id==0)
                {
                    $comment->parent_comment_id=NULL;
                }
                
                //echo CVarDumper::dump($comment->attributes,10,true);exit;
                        
                $result = array();
                if($comment->save())
                {
                    $result['code'] = 'success';
                    $this->beginClip("list");
                        $this->widget('comments.widgets.ECommentsListWidget', array(
                            'model' => $comment->ownerModel,
                            'showPopupForm' => false,
                        ));
                    $this->endClip();
                    $this->beginClip('form');
                        $this->widget('comments.widgets.ECommentsFormWidget', array(
                            'model' => $comment->ownerModel,
                        ));
                    $this->endClip();
                    $result['list'] = $this->clips['list'];
                }
                else 
                {
                    $result['code'] = 'fail';
                    $this->beginClip('form');
                        $this->widget('comments.widgets.ECommentsFormWidget', array(
                            'model' => $comment->ownerModel,
                            'validatedComment' => $comment,
                        ));
                    $this->endClip();
                }
                $result['form'] = $this->clips['form'];
                echo CJSON::encode($result);
            }
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Comment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
