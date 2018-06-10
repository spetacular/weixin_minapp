/*
    上传文件函数
    @param browser_dom 需要绑定上传时间的dom node类名
    @param input_name 需要回填url的form input的name
    @param filttype 文件类型,image,text,audio,video,bin
 */
function flowuploadimg(browser_dom,input_name,filetype) {
    if(filetype == undefined){
        filetype = "image";
    }
    var chunkSize;
    var accepttype;
    switch (filetype){
        case "image":
            accepttype = 'image/*';
            chunkSize = 10*1024 * 1024;
            break;
        case "text":
            chunkSize = 10*1024 * 1024;
            accepttype = 'text/*';
            break;
        case "audio":
            chunkSize = 50*1024 * 1024;
            accepttype = 'audio/*';
            break;
        case "video":
            chunkSize = 50*1024 * 1024;
            accepttype = 'video/*';
            break;
        case "bin":
            chunkSize = 50*1024 * 1024;
            accepttype = "application/octet-stream";
        default :
            chunkSize = 10*1024 * 1024;
            accepttype = 'image/*';
            break;
    }

    var r = new Flow({
        target: base_url+'/index.php/home/index/upload',
        chunkSize: chunkSize,
        testChunks: false
    });
    // Flow.js isn't supported, fall back on a different method
    if (!r.support) {
        alert("您的浏览器不支持上传文件");
        return;
    }

    r.assignBrowse($('.'+ browser_dom ), false, false, {accept: accepttype});


    // Handle file add event
    r.on('fileAdded', function (file) {
        file.name = newFileName(file.name);
    });
    r.on('filesSubmitted', function (file) {
        r.upload();
    });

    r.on('fileSuccess', function (file, message) {
        var json = jQuery.parseJSON(message);
        $('input[name='+input_name+']').val(json.url);
        file.cancel();

    });

    window.r = {
        pause: function () {
            r.pause();
        },
        cancel: function () {
            r.cancel();
        },
        upload: function () {
            r.resume();
        },
        flow: r
    };


}


function newFileName(oldfilename){
    var ext = /\.[^\.]+$/.exec(oldfilename);
    var randonstr = randomString(8)+'-'+randomString(4)+'-'+randomString(4)+'-'+randomString(4)+'-'+randomString(12);
    return randonstr + ext;
}

function randomString(length) {
    var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'.split('');

    if (! length) {
        length = Math.floor(Math.random() * chars.length);
    }

    var str = '';
    for (var i = 0; i < length; i++) {
        str += chars[Math.floor(Math.random() * chars.length)];
    }
    return str;
}
