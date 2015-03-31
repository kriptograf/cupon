<?php if(count($comments) > 0):?>
    <ul class="comments-list">
        <?php foreach($comments as $comment):?>
            <li id="comment-<?php echo $comment->comment_id; ?>">
                <?php 
                //выделяем цветом ответы хозяина компании
                        if($comment->company->user_id === $comment->creator_id)
                        {
                            $class = 'comment-y-wrapper';
                        }
                        else
                        {
                            $class = 'comment-wrapper';
                        }
                 ?>
                <?php $val = CompaniesRating::model()->findByAttributes(array('user_id'=>$comment->creator_id, 'company_id'=>$comment->company->id))->value;?>
                <div class="<?php echo $class;?>">
                    <div class="comment-header">
                        <?php //echo CVarDumper::dump($comment,10,true);?>
                        <span class="usname"><?php echo $comment->userName;?> / </span>  &nbsp;&nbsp;<span class="uscommrate">
                            <?php $this->widget('CStarRating',array(
                                'name'=>'rating'.rand(10, 1000), 
                                'value'=>$val, 
                                'readOnly'=>true, 
                                'ratingStepSize'=>1, 
                                'maxRating'=>5,
                                ));?>
                        </span>
                        <br>
                        <div class="comment-date">
                            <?php echo date('d.m.Y',$comment->create_time);?>
                        </div>
                    </div>
                    <?php if($this->adminMode === true):?>
                        <div class="admin-panel">
                            <?php if($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROVED)
                            {
                                echo CHtml::link(Yii::t('CommentsModule.msg', 'approve'), Yii::app()->urlManager->createUrl(
                                    CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                                ), array('class'=>'approve'));
                            }
                            ?>
                            <?php echo CHtml::link(Yii::t('CommentsModule.msg', 'delete'), Yii::app()->urlManager->createUrl(
                                CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                            ), array('class'=>'delete'));
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="comment-text">
                        <?php echo CHtml::encode($comment->comment_text);?>
                    </div>
                    <?php
                        if($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false))
                        {
                            //echo CHtml::link(Yii::t('CommentsModule.msg', 'Add comment'), '#', array('rel'=>$comment->comment_id, 'class'=>'add-comment'));
                            echo CHtml::link(Yii::t('CommentsModule.msg', 'Ответить'), '#', array('rel'=>$comment->comment_id, 'class'=>'re-comment'));
                        }
                    ?>
                </div>
                <?php 
                if(count($comment->childs) > 0 && $this->allowSubcommenting === true) 
                {
                    $this->render('ECommentsWidgetComments', array('comments' => $comment->childs));
                }       
                ?>
                <?php
//                    if($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false))
//                    {
//                        //echo CHtml::link(Yii::t('CommentsModule.msg', 'Add comment'), '#', array('rel'=>$comment->comment_id, 'class'=>'add-comment'));
//                        echo CHtml::link(Yii::t('CommentsModule.msg', 'Ответить'), '#', array('rel'=>$comment->comment_id, 'class'=>'add-comment'));
//                    }
                ?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p><?php echo Yii::t('CommentsModule.msg', 'No comments');?></p>
<?php endif; ?>

