/**
 * Created with JetBrains PhpStorm.
 * User: admin
 * Date: 24.03.13
 * Time: 18:07
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){
    $('#print').click(function(event){
        event.preventDefault();
        var url = $('#print').attr('href');
        if(url == "false")
        {
            alert('Для того, что бы распечатать купон, вы должны зарегистрироваться.');
        }
        else
        {
            openDialog(url,815,1147);
        }

    });
});

function openDialog(url, width, height)
{
    var params = ''
    params = "left="+((screen.width/2)-(width/2))+","
    params += "top="+((screen.height/2)-(height/2));
    win=window.open(url,"asd","toolbar=0,directories=0,menubar=0,status=0,width="+width+",height="+height+",resizable=1,scrollbars=1,"+params);
    win.focus();
    return win
}
