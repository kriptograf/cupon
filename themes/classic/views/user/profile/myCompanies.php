<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">
                <div class="title-companies">
                    <!--                <img src="/images/cat-company.png" alt="Справочник компаний" />-->
                    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                	'separator'=>' / ',
                    'links'=>$this->breadcrumbs,
                    'homeLink'=>CHtml::link('Справочник',Yii::app()->createUrl('/companies')),
                	//'htmlOptions'=>array('class'=>'well well-small'),
                )); ?><!-- breadcrumbs -->
                </div>

                <div class="company-wrapper">
                    <div class="catalog">Мои компании</div>
                    <?php $this->widget('zii.widgets.CListView', array(
                        'id' => 'list-actions',
                        'dataProvider'=>$dataProvider,
                        'itemView'=>'_myCompanyView',
                        'summaryText'=>false,
                        'template' => '{items}',
                    ));
                    ?>
                    <?php Yii::app()->getClientScript()->registerCssFile( Yii::app()->baseUrl.'/css/jquery.comprating.css', 'screen, projection');?>
                    <?php Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.rating-2.0.js' , CClientScript::POS_HEAD);?>
                    <?php Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/comprate.js' , CClientScript::POS_HEAD);?>
                    <?php Yii::app()->clientScript->registerScriptFile('/js/jquery.equal-height-columns.js',  CClientScript::POS_HEAD);?>
                </div>
                <script>
                    $('.company-view').equalHeightColumns();
                    $('.company-wrapper').ajaxComplete(function(event,request, settings){
                        $('.company-view').equalHeightColumns();
                    });
                </script>

            </div>  <!-- ### end main section -->
            <div class="sidebar">
                <ul class="big-nav">
                    <!--                <li><a href="<?php //echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>-->
                    <li><a href="<?php echo Yii::app()->createUrl('/kupones');?>">Все акции</a> </li>
                </ul>
                <?php $this->widget('CTreeView',
                    array(
                        'id'=>'treecategory',
                        'cssFile'=>'/css/jquery.treeview.css',
                        'data' => CategoriesCompany::generateTree(),
                        'collapsed'=>true,
                        'persist'=>'cookie',
                        'animated'=>'slow',
                        'htmlOptions'=>array(
                            'class'=>'right-menu'
                        ),
                    )
                );
                ?>

                <!--            <ul class="right-menu">
                <?php //foreach($categories as $category):?>
                <li><a href="<?php //echo Yii::app()->createUrl('/category/'.$category->id);?>"><?php //echo $category->name;?> <span class="count-cat"><?php //echo $category->countCompanies; ?></span></a></li>
                <?php //endforeach;?>
            </ul>-->
            </div>  <!-- ### end sidebar section -->
        </div>

    </div>
</div>

