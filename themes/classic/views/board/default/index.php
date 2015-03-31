<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">

                <h1 class="default-title">Бесплатные объявления</h1>

                <div class="sections">

                    <a id="realty" href="/board/realty">Недвижимость</a>
                    <a id="auto" href="/board/auto">Авто</a>
                    <a id="work" href="/board/work">Работа</a><br>
                    <a id="goods" href="/board/ads">Товары и ...</a>
                    <a id="services" href="/board/services">Услуги</a>

                </div>

            </div>  <!-- ### end main section -->

            <div class="sidebar">
                <?php $this->widget('SectionsWidget');?>
            </div>  <!-- ### end sidebar section -->

        </div>

     </div>
</div>