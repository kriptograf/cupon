<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 06.03.13
 * Time: 0:02
 * To change this template use File | Settings | File Templates.
 */  ?>
<div class="loginform">
    <div class="close">
        <a class="link-close" href="javascript:;" onClick="$('.loginform').slideToggle(600);">&nbsp;</a>
    </div>
    <div id="ajaxlogin"></div>
</div>
    <script>

        $(document).ready(function(){
            $('.login').click(function(event){
                event.preventDefault();
                $('.registerform').slideUp(600);
                $('.loginform').slideToggle(600,function(){
                        $.get('/user/login/form',function(data){
                            $('#ajaxlogin').replaceWith('<div id="ajaxlogin">'+data+'</div>');
                        });
                });


            });
        });



    </script>