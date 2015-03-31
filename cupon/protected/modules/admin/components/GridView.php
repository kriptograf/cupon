<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 28.03.13
 * Time: 0:52
 * To change this template use File | Settings | File Templates.
 */
Yii::import('zii.widgets.grid.CGridView');

class GridView extends CGridView
{
    /**
     * Дополнительные кнопки
     * @var bool
     */
    public $groupActions = true;

    public $sub = false;

    public function init()
    {
        array_unshift($this->columns, array(

            'class'=>'CCheckBoxColumn',

            'selectableRows'=>2,

            'checkBoxHtmlOptions'=>array(

                'name'=>'group-checkbox-column[]',

            ),

            'htmlOptions'=>array(

                'class'=>'group-checkbox-column',

            ),

        ));

        return parent::init();

    }

    public function renderPager()
    {

        echo "<div class='pre-header'>";


        echo '<div class="pager">';

        if($this->groupActions)
        {
            if($this->sub)
            {
                echo CHtml::link('+ Добавить категорию', array('createRoot'), array('class'=>'add','onclick'=>'location.href=$(this).attr("href");'));
                echo CHtml::link('+ Добавить подкатегорию', array('createChild'), array('class'=>'add','onclick'=>'location.href=$(this).attr("href");'));
            }
            else
            {
                echo CHtml::link('+ Добавить', array('create'), array('class'=>'add','onclick'=>'location.href=$(this).attr("href");'));
            }


        }
        echo CHtml::button('x Удалить', array(

            'id'=>'group-operation-submit',

            'onclick'=>'groupOperation()',

        ));
        
        echo '</div>';

        
        parent::renderPager();

        echo "</div>";

        /**$actionLinks = array();

        foreach($this->groupActions as $k=>$v) {

            $actionLinks[$k] = Yii::app()->controller->createUrl($k);

        }*/

        $actionLinks = Yii::app()->controller->createUrl('groupDelete');
        $actionLinks = json_encode($actionLinks);

        Yii::app()->clientScript->registerScript('go', "

          var actionLinks = $actionLinks;

          function groupOperation(){

             var post_data = $('.group-checkbox-column input').serializeArray();

             if(post_data == '')
             {
                  alert(post_data+'Выберите минимум одну запись');
                  return false;
             }
             var action = 'groupDelete';

             var submit = $('#group-operation-submit');

             submit.attr('disabled', 'disabled');

             $.ajax({

                url: actionLinks,

                type: 'POST',

                data: $('.group-checkbox-column input').serializeArray(),

                complete: function(){

                   submit.removeAttr('disabled');

                },

                success: function(){

                   jQuery('#{$this->id}').yiiGridView('update');

                }

            });

       }

       ", CClientScript::POS_HEAD);

        //parent::renderPager();

    }
}