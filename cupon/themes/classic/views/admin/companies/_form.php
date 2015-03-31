<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'companies-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
        <?php echo $form->dropDownList($model, 'city_id', CHtml::listData(Cities::model()->findAll(), 'id_city','name'), array('empty'=>'- город -'));?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

    <?php
        $categories = new CategoriesCompany();
    ?>
    <div class="row">
        <?php echo $form->labelEx($categories,'Категория'); ?>
        <?php echo $form->dropDownList($categories,'id',CHtml::listData(CategoriesCompany::model()->getRootCategories(),'id','name'),array(
            'empty'=>'- Выберите категорию -',
            'options' => array($model->category->parent_id=>array('selected'=>true)),
            'ajax' => array(
                'type'=>'POST',
                'url'=>CController::createUrl('/getSubCat'),
                'update'=> '#'.CHtml::activeId($model, 'category_id'),
                'data'=>array('parent_id'=>'js:this.value'),
            )
        ))?>
        <?php echo $form->error($categories,'id'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php if(!$model->isNewRecord):?>
            <?php echo $form->dropDownList($model,'category_id',CHtml::listData(CategoriesCompany::model()->findAll('parent_id='.$model->category->parent_id),'id','name'),array('empty'=>'- Выберите подкатегорию -'))?>
        <?php else:?>
            <?php echo $form->dropDownList($model,'category_id',array('empty'=>'- Выберите подкатегорию -'))?>
        <?php endif;?>
        <?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php
        //Подключаем виджет редактора
        $this->widget('application.extensions.editor.CKkceditor',array(
            //конфигурация редактора и файлового менеджера
            "model"=>$model,                //атрибут model аналогия с $form->textArea, используется имя модели в элементе <textarea>
            "attribute"=>'description',         //Название поля в БД для сохранения текста. То же самое, что $form->textArea($model,'content'
            "height"=>'200px',//Высота окна редактора
            "width"=>'100%', //Ширина окна редактора
            //Здесь главное не напутать с путями
            "filespath"=>Yii::app()->basePath."/../media/",//Путь к файлам на сервере.Такая запись будет соответствовать расположению папки media на одном уровне с index.php
            "filesurl"=>Yii::app()->baseUrl."/media/",//URL который подставляется в редактор после загрузки файла на сервер.
            //файлы сохраняются в папку media/images
        ) );
        ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'x'); ?>
        <?php echo $form->textField($model,'x'); ?>
        <?php echo $form->error($model,'x'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'y'); ?>
        <?php echo $form->textField($model,'y'); ?>
        <?php echo $form->error($model,'y'); ?>
    </div>

	<div class="row">
        <?php if($model->isNewRecord):?>
            <?php echo $form->labelEx($model,'logo'); ?>
            <?php echo $form->fileField($model,'logo'); ?>
            <?php echo $form->error($model,'logo'); ?>
        <?php else:?>
            <div id="img">
                <?php echo $form->labelEx($model,'logo'); ?>
                <img src="/content/companies/logo/<?php echo $model->logo;?>" />
                <br>
                <a href="#" id="change">Изменить</a>
                <?php echo $form->hiddenField($model, 'logo', array('value'=>$model->logo)); ?>
            </div>
        <?php endif;?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address'); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phones'); ?>
		<?php echo $form->textArea($model,'phones',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'phones'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link'); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'boss'); ?>
        <?php echo $form->textField($model,'boss'); ?>
        <?php echo $form->error($model,'boss'); ?>
    </div>
    
    <div class="row">
         <?php echo $form->labelEx($model,'boss_contacts'); ?>
         <?php echo $form->textField($model,'boss_contacts'); ?>
         <?php echo $form->error($model,'boss_contacts'); ?>
    </div>
    
    <div class="row">
         <?php echo $form->labelEx($model,'boss_phones'); ?>
         <?php echo $form->textField($model,'boss_phones'); ?>
         <?php echo $form->error($model,'boss_phones'); ?>
    </div>
    
    <div class="row">
          <?php echo $form->labelEx($model,'schedule'); ?>
          <?php echo $form->textField($model,'schedule'); ?>
          <?php echo $form->error($model,'schedule'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($gallery,'img'); ?>
        <?php
        $this->widget('CMultiFileUpload', array(
            'model'=>$gallery,
            'attribute'=>'files',
            'accept'=>'jpg|gif|png',
            'duplicate' => 'Дубликат файла!', // useful, i think
            'denied' => 'Не верный формат файла', // useful, i think
        ));
        ?>
        <div class="gal">
            <?php foreach($model->gallery as $thumb):?>
                <a title="Удалить" href="<?php echo $thumb->id;?>" id="img<?php echo $thumb->id;?>">
                <?php echo CHtml::image('/content/companies/thumbs/'.$thumb->thumb,'Превью',array('width'=>100));?>
                </a>
             <?php endforeach;?>
        </div>
        <script>
            $(document).ready(function(){
                $('.gal a').click(function(event){
                    event.preventDefault();
                    var id = $(this).attr('href');
                    var lnk = '/admin/companies/delItemGallery';
                    $.ajax({
                            url: lnk,
                            global: false,
                            type: "POST",
                            data: ({id : id}),
                            dataType: "json",
                            success: function(msg){
                                $('#img'+msg.msg).remove();
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert(textStatus);
                            }
                        }
                    );
                });

            });
        </script>
        <p class="hint">Вы можете загрузить несколько изображений</p>
    </div>

<div class="row">
    <?php echo $form->labelEx($model,'video'); ?>
    <?php echo $form->textArea($model,'video',array('rows'=>6, 'cols'=>40)); ?>
    <?php echo $form->error($model,'video'); ?>
</div>

<div class="row">&nbsp;</div>
<div class="row" style="margin-bottom: 0;">
    <label>Новости</label>
</div>
<?php
$ex_count = 4;
$count = count($model->newsCompany);
$i = 1;
$res_count = $ex_count-$count;
$counter = $res_count;
?>
<?php if(!$model->isNewRecord):?>
<?php foreach($model->newsCompany as $new):?>
<div class="row">

    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'id'=>'NewsCompany_date'.$i,
        'model'=>$news, //модель
        'attribute'=>'date[]', //атрибут модели
        'language'=>'ru', //язык локализации виджета
        'value'=>$new->date,
        // дополнительные опции - такие же как JQuery UI Datepicker
        'options'=>array(
            'showAnim'=>'fold',
            'showOn'=>'button',
            'buttonImage'=>'/images/calendar.gif',
            'dateFormat'=>'dd-mm-yy',

        ),
        'htmlOptions'=>array(
            'class'=>'datepicker',
            'title'=>'Выбрать дату',
        ),
    ));
    ?>
    <span><?php echo date('d.m.Y',$new->date);?></span><br>
    <?php echo $form->textField($news,'text[]',array('class'=>'news-input','id'=>'news'.$i, 'placeholder'=>'не более 300 символов', 'value'=>$new->text)); ?>

    <?php echo $form->error($news,'text[]'); ?>
</div>
    <?php $i++;?>
<?php endforeach;?>
<?php else:?>
<?php for($j=1;$j<5;$j++):?>
<div class="row">
    <?php
    //$counter++;
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'id'=>'NewsCompany_date'.$j,
        'model'=>$news, //модель
        'attribute'=>'date[]', //атрибут модели
        'language'=>'ru', //язык локализации виджета
        // дополнительные опции - такие же как JQuery UI Datepicker
        'options'=>array(
            'showAnim'=>'fold',
            'showOn'=>'button',
            'buttonImage'=>'/images/calendar.gif',
            'dateFormat'=>'dd-mm-yy',

        ),
        'htmlOptions'=>array(
            'class'=>'datepicker',
            'title'=>'Выбрать дату',
        ),
    ));
    ?>
    <?php echo $form->textField($news,'text[]',array('class'=>'news-input','id'=>'news'.$j,'placeholder'=>'не более 300 символов')); ?>

    <?php echo $form->error($news,'text[]'); ?>
</div>
<?php endfor;?>
<?php endif;?>

<div class="row">&nbsp;</div>


<div class="row">
            <?php echo $form->labelEx($model,'status'); ?>
            <?php echo $form->checkBox($model, 'status',array('1'=>'Опубликована','0'=>'Не опубликована'));?>
            <?php echo $form->error($model,'status'); ?>
	</div>
    
        <div class="row">
            <?php echo $form->labelEx($model,'checked'); ?>
            <?php echo $form->checkBox($model, 'checked');?>
            <?php echo $form->error($model,'checked'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

    <script>
        $(document).ready(function(){
            $('#change').click(function(event){
                event.preventDefault();

                $('#img').replaceWith('<?php echo $form->labelEx($model, 'logo'); ?><?php echo $form->fileField($model, 'logo'); ?><?php echo $form->error($model, 'logo'); ?> ');
            });
        });
    </script>

</div><!-- form -->