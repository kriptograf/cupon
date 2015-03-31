/**
 * Created with JetBrains PhpStorm.
 * User: admin
 * Date: 11.05.13
 * Time: 19:48
 * To change this template use File | Settings | File Templates.
 */

function Output(msg) {
    var m       = document.getElementById("messages");
    m.innerHTML = msg + m.innerHTML;
}
function FileSelectHandler(e) {

    // fetch FileList object
    var files = e.target.files || e.dataTransfer.files;

    // process all File objects
    for (var i = 0, f; f = files[i]; i++) {
        ParseFile(f);
    }

}

function ParseFile(file) {
    // display an image
    if (file.type.indexOf("image") == 0) {
        var reader = new FileReader();
        reader.onload = function(e) {
            Output(
                '<img src="' + e.target.result + '" />'
            );
        }
        reader.readAsDataURL(file);
    }


}

function Init() {
    //var fileselect = document.getElementById("AdsImg_files");

    var fileselect = $('.MultiFile-applied');

    // file select
    fileselect.addEventListener("change", FileSelectHandler, false);

    // is XHR2 available?
    var xhr = new XMLHttpRequest();
    if (xhr.upload) {

        // file drop
        //filedrag.addEventListener("dragover", FileDragHover, false);
        //filedrag.addEventListener("dragleave", FileDragHover, false);
        //filedrag.addEventListener("drop", FileSelectHandler, false);
        //filedrag.style.display = "block";

        // remove submit button
        //submitbutton.style.display = "none";
    }

}

// call initialization file
if (window.File && window.FileList && window.FileReader) {
    Init();
}

