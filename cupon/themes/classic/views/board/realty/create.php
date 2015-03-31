<?php
/* @var $this RealtyController */
/* @var $model Realty */

$this->breadcrumbs=array(
	'Realties'=>array('index'),
	'Create',
);
?>

<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">

                <div id="form-title" class="title-ads">
                    <h1>Добавление недвижимости</h1>
                </div>

                <!-- filter-->
                <?php //$this->widget('FilterWidget');?>

                <?php echo $this->renderPartial('_form', array(
                    'model'=>$model,
                    'category'=>$category,
                    'city'=>$city,
                    'types'=>$types,
                    'photos' => $photos,
                )); ?>

            </div>  <!-- ### end main section -->

            <div class="sidebar">
                <?php $this->widget('SectionsWidget');?>
            </div>  <!-- ### end sidebar section -->
        </div>
    </div>
</div>
