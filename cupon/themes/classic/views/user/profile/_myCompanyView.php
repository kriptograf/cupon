<div class="company-view">
    <div class="company-view-inner">

        <div class="company-name">
            <a href="/companies/update/<?php echo $data->id;?>">Редактировать</a><br>
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
            <?php if(FALSE):?>
                <div class="pano">
                    <a href="#" class="pano-link">3D поанорама</a>
                </div>
            <?php endif;?>
            <?php if($data->countKupons):?>
                <div class="kupons">
                    <span class="lbl">купоны</span> <span class="green-round"><?php echo $data->countKupons;?></span>
                </div>
            <?php endif;?>
            <?php if(FALSE):?>
                <div class="board">
                    <span class="lbl">объявления</span> <span class="red-round">0</span>
                </div>
            <?php endif;?>
        </div>

        <div class="company-info">
            <table>
                <tr>
                    <td>
                        <div class="company-address">
                            г.<?php echo $data->city->name?> <?php echo CHtml::encode($data->address); ?>
                        </div>
                    </td>
                    <td>
                        <div class="company-scedule">
                            <?php echo CHtml::encode($data->schedule);?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="company-phones">
                            <?php
                            $phone = explode(',', $data->phones);
                            foreach($phone as $p)
                            {
                                echo CHtml::encode($p).'<br>';
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="company-link">
                            <?php if($data->link):?>
                                <?php echo CHtml::link(CHtml::encode($data->link), $data->link); ?>
                            <?php endif;?>
                        </div>
                    </td>
                </tr>
            </table>




        </div>
    </div>



</div>