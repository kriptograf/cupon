<?php
/* @var $this RealtyController */
/* @var $model Realty */

$this->breadcrumbs=array(
    'Sections'=>array('index'),
    $model->title,
);
?>

<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">

                <div id="form-title" class="title-section">
                    <h1 class="section-h1">Недвижимость</h1>

                    <span class="add-board">
                        <a href="/board/realty/create">Добавить объявление</a>
                    </span>
                    <?php
                    $crit = new CDbCriteria();
                    $crit->compare('checked',1);
                    $crit->compare('status',1);
                    if($city)
                    {
                        $crit->compare('city_id',$city);
                    }

                    ?>
                    <span class="count-board">Объявлений / <?php echo Realty::model()->count($crit);?></span>
                </div>

                <!-- filter-->
                <?php $this->widget('RealtyFilterWidget');?>


                <!-- список категорий
                <h2 class="board-cat-title">Категории</h2>-->
                <!--<ul class="cat-menu">
                    <?php //foreach($categories as $cat):?>
                        <?php //if($cat->countRealty):?>
                        <li><a href="<?php //echo Yii::app()->createUrl('/board/realty/category/id/'.$cat->id);?>"><?php //echo $cat->name;?> </a><span class="count-ads"><?php //echo $cat->countRealty;?></span></li>
                        <?php//endif;?>
                    <?php //endforeach;?>
                </ul>
                <a class="openall" href="#">Открыть все &rarr;</a>-->

                <!-- ### ajax infinity pagination widget -->
                <?php
                $count_records = (isset(Yii::app()->request->cookies['page_board']->value))?Yii::app()->request->cookies['page_board']->value:'';
                $pageSize=$count_records;
                if(!$count_records)
                {
                    $count_records=25;
                    $pageSize=25;
                }

                $footer = $this->renderPartial('footer',array('count_records'=>$count_records),true,false);
                ?>
                <div class="spacer-list"></div>
                <?php
                $this->widget('EListView', array(
                        'id' => 'list-actions',
                        'dataProvider' => $dataProvider,
                        'ajaxUpdate'=>'list-actions',
                        'itemView' => '_view',
                        'sorterHeader'=>'',
                        'summaryText'=>'Найдено объявлений: {count}',
                        'template' => '{summary} {sorter}{items} {pager} {sizer}',
                        'enableSorting'=>true,
                        'sorterCssClass'=>'filter-sorting sort',
                        'summaryCssClass'=>'board-summary',
                        'pager'=>array(
                            'cssFile'=>'/css/superpager.css',
                            'header'=>'Страницы: ',
                            'maxButtonCount'=>6,
                            'pageSize'=>$pageSize,
                            'prevPageLabel'  => '<img src="/images/pagination/left.png">',
                            'nextPageLabel'  => '<img src="/images/pagination/right.png">',
                        ),
                        'sortableAttributes'=>array(
                            'price'=>'По цене /',
                            'date_pub'=>'по дате',
                        ),
                        'links'=>$footer,
                    )
                );
                ?>

            </div>  <!-- ### end main section -->

            <div class="sidebar">
                <?php $this->widget('SectionsWidget');?>
            </div>  <!-- ### end sidebar section -->
        </div>
    </div>
</div>
