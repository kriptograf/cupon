<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 07.03.13
 * Time: 19:26
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="news-widget">
    <ul id="vertical-ticker">
        <?php foreach($news as $new):?>
        <li>

                <a href="#" id="news<?php echo $new->id_news;?>">
                    <img src="<?php echo ($new->image)?'/content/news/thumbs/'.$new->image:'/images/no-img.jpg';?>" class="news-widget-img">
                    <p class="news-widget-title"><?php echo $new->title;?></p>
                    <p class="news-widget-desc"><?php echo News::crop_news($new->content, 70);?></p>
                </a>

            <script>
                $(document).ready(function(){
                    $('#news<?php echo $new->id_news;?>').click(function(event){
                        event.preventDefault;
                        $.get("<?php echo Yii::app()->createAbsoluteUrl('/news/news/view/id/'.$new->id_news);?>",
                        function(data){
                            $('#newsdialog').html(data);
                            $( "#newsdialog" ).dialog( "open" );
                        }
                    );
                        //jQuery.facebox({ ajax: '<?php //echo Yii::app()->createAbsoluteUrl('/news/news/view/id/'.$new->id_news);?>' })
                    });
                });
            </script>
        </li>
        <?php endforeach;?>
    </ul>
</div>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'newsdialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'',
        'autoOpen'=>false,
        'width'=>'800',
        'modal'=>true,
        'show'=> array(
            'effect'=> "blind",
            'duration'=> 1000
            ),
        'hide'=> array(
            'effect'=> "explode",
            'duration'=> 1000
            ),
    ),
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>