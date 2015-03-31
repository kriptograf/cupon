<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
?>
<?php if(Yii::app()->user->isGuest):?>
<script>
$(document).ready(function(){
    $('.btn').attr('disabled','disabled');
    $('#companies-form input').focus(function(){
        $.facebox('Для добавления компании зарегистрируйтесь или войдите на сайт');
        setTimeout(function() {
            $('#facebox').fadeOut(600, function(){
            //$(this).remove();
            });
            $('#facebox_overlay').fadeOut(600, function(){
                //$(this).remove();
            });
        }, 3000);
    });
});
</script>
<?php endif;?>
<div class="form create">

<?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'companies-form',
                'enableAjaxValidation'=>false,
                'enableClientValidation' => true,
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data'
                    ),
                'clientOptions' => array(
                        'validateOnChange' => true,
                        'validateOnSubmit' => true,
                    ),
        )); ?>

	
    
        <div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-input','placeholder'=>'Кремлевская столовая №1')); ?>
        <?php echo $form->error($model,'title'); ?>
	    </div>
    
        <div class="row">
                <?php if($model->isNewRecord):?>
                    <?php echo $form->labelEx($model,'logo'); ?>
                    <div class="file-wrapper">
                        <?php echo $form->fileField($model,'logo'); ?>
                        <span class="file-text">Файл не выбран</span>
                    </div>  
                    <?php echo $form->error($model,'logo'); ?>
                <?php else:?>
                    <div id="img">
                        <?php echo $form->labelEx($model,'logo'); ?>
                        <img src="/content/companies/logo/<?php echo $model->logo;?>" width="80%">
                        <br>
                        <a href="#" id="change">Изменить</a>
                        <?php echo $form->hiddenField($model, 'logo', array('value'=>$model->logo)); ?>
                    </div>
                <?php endif;?>
	</div>
    
        <div class="row">
            <label>Фото</label>
            <div class="file-wrapper">
                <input id="Gallery_files" type="file" name="Gallery[files][]">
                <span class="file-text">Файл не выбран</span>
            </div>
            <?php //echo $form->error($model,'files[]'); ?>
        </div>
        <div class="row">
            <div class="file-wrapper">
<!--                <input id="ytCompanies_files1" type="hidden" name="Companies[files][]" value="">-->
                <input id="Gallery_files1" type="file" name="Gallery[files][]">
                <span class="file-text">Файл не выбран</span>
            </div>
        </div>
        <div class="row">
            <div class="file-wrapper">
<!--                <input id="ytCompanies_files2" type="hidden" name="Companies[files][]" value="">-->
                <input id="Gallery_files2" type="file" name="Gallery[files][]">
                <span class="file-text">Файл не выбран</span>
            </div>
        </div>
        <div class="row">
            <div class="file-wrapper">
<!--                <input id="ytCompanies_files3" type="hidden" name="Companies[files][]" value="">-->
                <input id="Gallery_files3" type="file" name="Gallery[files][]">
                <span class="file-text">Файл не выбран</span>
            </div>
        </div>
        <div class="row">
            <div class="tips">
                Вы можете прикрепить:<br /> • Картинку: gif, jpeg, png. 1,5 Мб.
            </div>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'video'); ?>
            <?php echo $form->textField($model,'video',array('class'=>'form-input')); ?>
            <?php echo $form->error($model,'video'); ?>
        </div>
    
       
        <div class="row">
            <label>Новости</label>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                      'id'=>'NewsCompany_date1',
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
		<?php echo $form->textField($news,'text[]',array('class'=>'news-input','id'=>'news1', 'placeholder'=>'не более 300 символов')); ?>

        <?php echo $form->error($news,'text[]'); ?>
	</div>
        <div class="row">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'id'=>'NewsCompany_date2',
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
		<?php echo $form->textField($news,'text[]',array('class'=>'news-input','id'=>'news2','placeholder'=>'не более 300 символов')); ?>

        <?php echo $form->error($news,'text[]'); ?>
	</div>
        <div class="row">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'id'=>'NewsCompany_date3',
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
		<?php echo $form->textField($news,'text[]',array('class'=>'news-input','id'=>'news3','placeholder'=>'не более 300 символов')); ?>

        <?php echo $form->error($news,'text[]'); ?>
	</div>
        <div class="row">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'id'=>'NewsCompany_date4',
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
		<?php echo $form->textField($news,'text[]',array('class'=>'news-input','id'=>'news4','placeholder'=>'не более 300 символов')); ?>

        <?php echo $form->error($news,'text[]'); ?>
	</div>

        <div class="row">&nbsp;</div> 
        
        
        <div class="row">
            <?php echo $form->labelEx($model,'city_id'); ?>
                    <?php echo $form->dropDownList($model, 'city_id', CHtml::listData(Cities::model()->findAll(), 'id_city','name'), array('empty'=>'- Выберите город -'));?>
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


	
        <table id="add-company-contacts">
            <tr>
                <td width="50%">
                    <div class="row">
                            <?php echo $form->labelEx($model,'address'); ?>
                            <?php echo $form->textField($model,'address', array('placeholder'=>'г.Щёлково, ул.Сиреневая, д.2')); ?>
                            <?php echo $form->error($model,'address'); ?>
                    </div>
                </td>
                <td width="50%">
                    <div class="row">
                            <?php echo $form->labelEx($model,'boss'); ?>
                            <?php echo $form->textField($model,'boss', array('placeholder'=>'Иванов Иван Иванович')); ?>
                        <span class="counter-hint">не будет опубликовано на сайте</span>
                            <?php echo $form->error($model,'boss'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                   <div class="row">
                            <?php echo $form->labelEx($model,'phones'); ?>
                            <?php echo $form->textField($model,'phones',array('placeholder'=>'8(496)567-90-78')); ?>
                            <span class="counter-hint">не более трех телефонов, разделенных запятыми</span>
                       <?php echo $form->error($model,'phones'); ?>
                    </div> 
                </td>
                <td width="50%">
                    <div class="row">
                            <?php echo $form->labelEx($model,'boss_contacts'); ?>
                            <?php echo $form->textField($model,'boss_contacts',array('placeholder'=>'ivanov@supercennik.ru')); ?>
                        <span class="counter-hint">не будет опубликовано на сайте</span>
                            <?php echo $form->error($model,'boss_contacts'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                   <div class="row">
                            <?php echo $form->labelEx($model,'link'); ?>
                            <?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255,'placeholder'=>'http://google.com')); ?>
                            <?php echo $form->error($model,'link'); ?>
                    </div> 
                </td>
                <td width="50%">
                    <div class="row">
                            <?php echo $form->labelEx($model,'boss_phones'); ?>
                            <?php echo $form->textField($model,'boss_phones'); ?>
                        <span class="counter-hint">не будет опубликовано на сайте</span>
                            <?php echo $form->error($model,'boss_phones'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <div class="row">
                            <?php echo $form->labelEx($model,'schedule'); ?>
                            <?php echo $form->textField($model,'schedule', array('placeholder'=>'понедельник - пятница, 10:00-20:00, суббота и воскресение - выходной')); ?>
                            <?php echo $form->error($model,'schedule'); ?>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50, 'style'=>'width:590px;','placeholder'=>'не более 1000 символов')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
        

	
        <div class="row">&nbsp;</div>
        <?php echo $form->errorSummary($model); ?>
        <div class="row">&nbsp;</div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить',array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$(document).ready(function(){
    $('input[type=file]').change(function (){
        // remove existing file info
        //$(this).next().val('');
        // get value
        var value = $(this).val();
        // get file name
        //var fileName = value.substring(value.lastIndexOf('/')+1);
        // get file extension
        //var fileExt = fileName.split('.').pop().toLowerCase();
        // append file info
        $(this).next().text(value);
    });
    
    $('#RegistrationForm_email').blur(function(){
        var email = $(this).val();
        $.post('/companies/companies/checkuser',{
            email:email
        },function(data){
            if(data.response)
            {
                $('#email').append('<input type="hidden" name="RegistrationForm[reg]" value="0" />');
                $('#pass').remove();
                $('#passConf').remove();
                alert('Вы уже регистрировались в системе. Компания будет привязана к вашему существующему аккаунту.');
            }
//            else
//            {
//                alert('нет такого');
//            }
            
        },'json');
    });
});

$(document).ready(function(){
    $("#news1,#news2,#news3,#news4").charCount({
        allowed: 300,
        warning: 20,
        counterText: 'oсталось: '
    });
    $("#Companies_description").charCount({
        allowed: 1000,
        warning: 20,
        counterText: 'oсталось: '
    });

});
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/charCount.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/comments.css');
?>