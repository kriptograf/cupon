<?php
/* @var $this CompaniesController */
/* @var $data Companies */
?>

<div class="view">

    <div class="company-logo">
        <img src="/content/companies/logo/<?php echo $data->logo;?>" alt="<?php echo CHtml::encode($data->title); ?>">
    </div>

    <div class="company-info">
        <div class="company-name">
             <h2><?php echo CHtml::link(CHtml::encode($data->title), array('/companies/view', 'id'=>$data->id)); ?></h2>
        </div>
        <div class="company-description">
            <?php echo $data->description; ?>
        </div>
        <div class="company-address">
            <?php echo CHtml::encode($data->city->name.' '.$data->address); ?>
        </div>
        <div class="company-phones">
            <?php echo CHtml::encode($data->phones); ?>
        </div>
        <div class="company-link">
            <?php if($data->link):?>
                <?php echo CHtml::link(CHtml::encode($data->link), $data->link); ?>
            <?php endif;?>
        </div>
    </div>


</div>