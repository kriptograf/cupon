<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
        <div class="main">
            <!-- ### ajax infinity pagination widget -->
            <?php
            $count_records = Yii::app()->request->cookies['page_kupones']->value;
            if(!$count_records)
            {
                $count_records=15;
            }

            $footer = $this->renderPartial('footer',array('count_records'=>$count_records),true,false);
            ?>
            <?php
            $this->widget('EListView', array(
                'id' => 'list-actions',
                'dataProvider' => $dataProvider,
                'itemView' => '_view',
                'template' => '{items} {pager} {sizer}',
                /*'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector'=>'.item-kupon',
                        'listViewId' => 'list-actions',
                        'header' => '',
                        'loaderText'=>'<img src="/images/ajax-loader.gif">',//'Загружаются еще ...',
                        'options' => array(
                            'history' => false,
                            'triggerPageTreshold' => 3,
                            'trigger'=>'Показать еще',
                            'thresholdMargin'=>-300
                        ),
                    )*/
                'pager'=>array(
                    'cssFile'=>'/css/superpager.css',
                    'header'=>'Страницы: ',
                    'maxButtonCount'=>6,
                    'pageSize'=>$pageSize,
                    'prevPageLabel'  => '<img src="/images/pagination/left.png">',
                    'nextPageLabel'  => '<img src="/images/pagination/right.png">',
                ),
                'links'=>$footer,
            )
            );
            ?>

        </div>  <!-- ### end main section -->
        <div class="sidebar">
            <ul class="big-nav">
                <li><a href="<?php echo Yii::app()->createUrl('/companies');?>">Все компании</a> </li>
<!--                <li><a href="<?php //echo Yii::app()->createUrl('/kupones');?>">Все акции</a> </li>-->
            </ul>
            <ul class="right-menu">
                <?php foreach($catKupones as $cat):?>
                <li><a href="<?php echo Yii::app()->createUrl('/kupones/category/'.$cat->id);?>"><?php echo $cat->name;?> <span class="count-cat"><?php echo $cat->countKupons; ?></span></a></li>
                <?php endforeach;?>
            </ul>
        </div>  <!-- ### end sidebar section -->
        </div>
    </div>
</div>
