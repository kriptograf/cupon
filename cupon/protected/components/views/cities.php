<div class="cities">
    <div id="city">
        <img alt="" src="/images/city.jpg">
        <span id="city-name"><?php echo $current->name;?></span> 
        <span id="arrow"><img src="/images/arrow.png" /></span>
    </div>
    <ul id="list-cities">
        <?php foreach ($cities as $city):?>
            <li id="<?php echo $city->id_city;?>">
                <a href="/setCity/<?php echo $city->id_city;?>"><?php echo $city->name;?></a>
            </li>
        <?php endforeach;?>
    </ul>
</div>
<script>
    $(document).ready(function(){
        $('#arrow').click(function(){
            $('#list-cities').slideToggle('slow',function(){
                if ($("#list-cities").is(":hidden")) {
                    $("#arrow img").attr('src','/images/arrow.png');
                } else {
                  $("#arrow img").attr('src','/images/rarrow.png');
                }
            });
            $('#list-cities').css('z-index','10000');
            
        });
    });
</script>