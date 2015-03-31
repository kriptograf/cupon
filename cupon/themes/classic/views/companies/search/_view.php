<?php
/* @var $this CategoriesCompanyController */
/* @var $data CategoriesCompany */
?>

<div class="company-view">
    <div class="company-view-inner">
        
        <div class="company-name">
            <h2><a href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>"><?php echo CHtml::encode($data->title); ?></a></h2>
        </div>
        
        <div class="company-description">
            <?php echo Companies::crop($data->description, 250); ?>
            <br />
            <a href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>" class="more">Читать далее ...</a>
        </div>
        
        <div class="company-logo">
            <img src="/content/companies/logo/<?php echo $data->logo;?>" alt="<?php echo CHtml::encode($data->title); ?>">
        </div>
        
        <div class="other-info">
            <div class="rate">
                Народный рейтинг<br />
                <?php 
//                $this->widget('ext.dzRaty.DzRaty', array(
//                    'name' => 'rating_'.$data->id,
//                    'value' => $data->rating,
//                    'options' => array(
//                        'readOnly' => TRUE,
//                        'size' => 22,
//                        'noRatedMsg'=> 'Пока еще нет голосов!',
//                        'starOff'  => 'star-off-big.png',
//                        'starOn'  => 'star-on-big.png'
//                    ),
//                ));
                ?>
                <div class="rating2">
                    <input type="hidden" name="val" value="<?php echo $data->rating;?>"/>
                </div>
                
                <script>
                    $(".rating2").ajaxComplete(function(event,request, settings){
                        $(function(){
                            $('.rating2').rating({
                                image: '/css/rating/star.png',
                                readOnly: true
                            });
                        });

                    });
                </script>
            </div>
            <div class="views">
                <div class="review"><?php echo $data->views;?></div> <!-- ### сюда выводить просмотры -->
                <div class="count-comments"><?php echo $data->commentsCount;?></div> <!-- ### сюда комменты -->
            </div>
            <div class="pano">
                <a href="#" class="pano-link">3D поанорама</a>
            </div>
            <div class="kupons">
                <span class="lbl">купоны</span> <span class="green-round"><?php echo $data->countKupons;?></span>
            </div>
            <div class="board">
                <span class="lbl">объявления</span> <span class="red-round">0</span>
            </div>
        </div>

        <div class="company-info"> 
            <div class="company-address">
                <?php echo CHtml::encode($data->address); ?>
            </div>
            <div class="company-scedule">
                <?php echo CHtml::encode($data->schedule);?>
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
    


</div>

