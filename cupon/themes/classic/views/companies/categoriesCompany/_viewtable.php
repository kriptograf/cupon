<?php
/* @var $this CategoriesCompanyController */
/* @var $data CategoriesCompany */
?>

<?php if($index == 0):?>
    <tr class="separator">
<?php endif;?>
<td class="company-view">
        <table class="company-view-inner">
            <tr>
                <td colspan="2" class="bottom">
                    <div class="company-name">
                        <h2><a href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>"><?php echo CHtml::encode($data->title); ?></a></h2>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="company-description">
                        <?php echo Companies::crop(strip_tags($data->description), 220); ?>
                        <br />
                        <a href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>" class="more">Читать далее ...</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="company-logo">
                        <a class="logo-link" href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>">
                            <div  class="logo-helper">
                                <img src="/content/companies/logo/<?php echo $data->logo;?>" alt="">
                            </div>
                        </a>
                    </div>
                </td>
                <td class="top">
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
                                $("div.main").ajaxComplete(function(event,request, settings){
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
                            <div class="review">
                                <a class="other-link" href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>">
                                    <?php echo $data->views;?>
                                </a>
                            </div> <!-- ### сюда выводить просмотры -->
                            <div class="count-comments">
                                <a class="other-link" href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>">
                                    <?php echo $data->commentsCount;?>
                                </a>
                            </div> <!-- ### сюда комменты -->
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
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="company-info">
                        <table>
                            <tr>
                                <td class="half">
                                    <a class="other-link" href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>">
                                        <div class="company-address">
                                            <?php echo CHtml::encode(Companies::crop($data->address,100)); ?>
                                        </div>
                                    </a>
                                </td>
                                <td class="half">
                                    <a class="other-link" href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>">
                                        <div class="company-scedule">
                                            <?php echo CHtml::encode(Companies::crop($data->schedule,100));?>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="half">
                                    <a class="other-link" href="<?php echo $this->createUrl('/companies/'.$data->category->id.'/'.$data->id);?>">
                                        <div class="company-phones">
                                            <?php
                                            $phone = explode(',', $data->phones);
                                            foreach($phone as $p)
                                            {
                                                echo CHtml::encode($p).'<br>';
                                            }
                                            ?>
                                        </div>
                                    </a>
                                </td>
                                <td class="half">
                                    <div class="company-link">
                                        <?php if($data->link):?>
                                            <?php
                                                if(!substr_count($data->link,'http://',0,7))
                                                {
                                                    $data->link = 'http://'.$data->link;
                                                }
                                            ?>
                                            <?php echo CHtml::link(CHtml::encode(str_replace('http://','',$data->link)), $data->link, array('target'=>'_blank')); ?>
                                        <?php endif;?>
                                    </div>
                                </td>
                            </tr>
                        </table>




                    </div>
                </td>
            </tr>
        </table>

</td>
<?php if($index >0 && ($index+1)%2==0):?>
</tr><tr class="separator">
<?php endif;?>
