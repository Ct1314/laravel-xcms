
loadShow = function(){
    $("#loading").show();
};
loadFadeOut=function(){
    $("#loading").fadeOut(500);
};
(function($,exports){
    var upload = function () {};
    upload.prototype.init = function (el,config) {
        var config = $.extend({
            language: 'zh',
            dropZoneEnabled:false,
            showUpload:false,
            maxFileCount:1,
            uploadUrl:'',
            uploadExtraData:{
                _token:$('meta[name="_token"]').attr('content'),
                width:0,
                height:0
            }
            // allowedFileTypes:["video"],
            // allowedFileExtensions:['mp4','webm','ogg'],
            // initialPreview:[],
            // initialPreviewConfig: [],
            // initialPreviewAsData: true,
            // initialPreviewFileType: 'image'
        },config);
        el.fileinput(config);
    };
    upload.prototype.event = function (el,delUrl,inputName) {
        // 移除文件
        el.on('fileclear', function() {
            var paths = [];
            var imageElements = $('input[name="'+inputName+'"]');
            $.each(imageElements,function (k,v) {
                paths.push($(v).val());
            });
            if(paths.length <=0) return;
            $.ajax({
                method:'POST',
                url:delUrl,
                data:{'paths':paths},
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                },
                beforeSend:function () {
                    loadShow();
                },
                success:function (res) {
                    loadFadeOut();
                    if(res.success) {
                        toastr.success(res.message);
                        $('input[name="'+inputName+'"]').remove();
                        return;
                    }
                    toastr.warning(res.message);
                }
            })
        });

        // 上传成功
        el.on('fileuploaded', function(event, data) {
            var $input = '<input type="hidden" value="'+data.response.path+'" name="'+inputName+'">';
            $(this).append($input);
            toastr.success(data.response.message);
        });

        // 上传成功后删除
        el.on('filesuccessremove', function(event, key) {
            var paths = [];
            var imageElements =  $('input[name="'+inputName+'"]');

            // 大于1个时
            if(imageElements.length > 1) {
                $.each(imageElements,function (k,v) {
                    paths.push($(v).val());
                });
            }else {
                paths = imageElements.val();
            }
            $.ajax({
                method:'POST',
                url:delUrl,
                data:{'paths':paths},
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                },
                beforeSend:function () {
                    loadShow();
                },
                success:function (res) {
                    loadFadeOut();
                    if(res.success) {
                        toastr.success(res.message);
                        $('input[name="'+inputName+'"]').remove();
                        return;
                    }
                    toastr.warning(res.message);
                }
            })
        });

        // 删除预览文件
        el.on('filedeleted', function(event, key,jqXHR) {
            if(jqXHR.responseJSON.success) {
                toastr.success(jqXHR.responseJSON.message);
                return true;
            }
            toastr.error(jqXHR.responseJSON.message);
            return false;
        });
    }
    exports.upload = new upload;
})(jQuery,window);
