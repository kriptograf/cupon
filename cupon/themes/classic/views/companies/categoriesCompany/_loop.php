<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 26.04.13
 * Time: 17:06
 * To change this template use File | Settings | File Templates.
 */?>
<?php $this->widget('zii.widgets.CListView', array(
    'id' => 'list-actions',
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'summaryText'=>false,
    'ajaxUpdate'=>true,
    'template' => '{items} {pager}',
    'pager' => array(
            'class' => 'ext.infiniteScroll.IasPager',
            'rowSelector'=>'.company-view',
            'listViewId' => 'list-actions',
            'header' => '',
            'loaderText'=>'<img src="/images/ajax-loader.gif">',//'Загружаются еще ...',
            'options' => array(
                'history' => false,
                'triggerPageTreshold' => 10,
                'trigger'=>'Показать еще',
                'thresholdMargin'=>-300
            ),
        )
));
?>
<?php Yii::app()->getClientScript()->registerCssFile( Yii::app()->baseUrl.'/css/jquery.comprating.css', 'screen, projection');?>
<?php Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.rating-2.0.js' , CClientScript::POS_HEAD);?>
<?php Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/comprate.js' , CClientScript::POS_HEAD);?>
<?php ?>
</div>
<script>
    $(document).ready(function(){
        $('.company-view').equalHeightColumns();
    });
    //$('.company-view').equalHeightColumns();
</script>