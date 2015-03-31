/**
 * Created with JetBrains PhpStorm.
 * User: admin
 * Date: 23.03.13
 * Time: 20:17
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){

    $('#vertical-ticker').css('margin-top',-60);

    function scrolling()
    {
        $('#vertical-ticker').animate({
            marginTop: 0
        }, 600, function(){
            $('#vertical-ticker').css('marginTop', -60);
            var el = $('#vertical-ticker li:last').detach();
            el.prependTo('#vertical-ticker');
        })
    }

    setInterval(scrolling,5000);

});
