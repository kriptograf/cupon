<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 06.03.13
 * Time: 0:02
 * To change this template use File | Settings | File Templates.
 */ ?>
<div class="registerform">
    <div class="close">
        <a class="link-close" href="javascript:;" onClick="$('.registerform').slideToggle(600);">&nbsp;</a>
    </div>
    <div id="ajax"></div>
</div>
<script>
    $(document).ready(function(){
        $('.register').click(function(event){
            event.preventDefault();
            $('.loginform').slideUp(600);
            $('.registerform').slideToggle(600,function(){
                if($('.registerform').css('display')=='none')
                {
                    $('.ui-datepicker').remove();
                }
                else
                {
                    $.get('/user/registration/form',function(data){
                        $('#ajax').replaceWith('<div id="ajax">'+data+'</div>');
                        $('.ui-datepicker').css('display','none');
                    });
                }
            });


        });
    });
</script>