<?php

namespace Admin\Form;
/*
* name FileImage.php
* user Yuanchang.xu
* date 2017/5/3
*/

class FileInput
{
    protected $options;

    public function __construct(array $options)
    {
        $w = !empty($options ['width'])? $options ['width'] : 0 ;
        $h = !empty($options ['height'])? $options ['height'] : 0 ;

        $defaults = [
            'language'          => 'zh',
            'showUpload'        => false,
            'dropZoneEnabled'   => false,
            'uploadExtraData'   => [
                '_token' => csrf_token(),
                'width'  => $w,
                'height' => $h,
            ]
        ];
        $this->options = array_merge($defaults,$options);
    }

    public function fileUploaded()
    {
        $id = $this->options['id'];
        $hidden = $this->options['hidden'];
        return  <<<EOT
    $('#$id').on('fileuploaded', function(event, data, previewId, index) {
        if (data.response.success) {
            var removeBtn = $('#'+previewId).find('.kv-file-remove').attr('data-path',data.response.path);
            var input = '<input type="hidden" value="'+data.response.path+'" name="$hidden" id="input-'+previewId+'">';
            $(this).append(input);
            toastr.success(data.response.message);
        } else 
            toastr.error(data.response.message);
    });
EOT;
    }

    public function fileSuccessRemove()
    {
        $id = $this->options['id'];
        $deleteUrl = !empty($this->options['deleteUrl'])?url($this->options['deleteUrl']) : url('/admin/delete/image');
        $token = csrf_token();
        return <<<EOT
$('#$id').on('filesuccessremove', function(event, previewId) {
    var path = $('#'+previewId).find('.kv-file-remove').attr('data-path');
    $.ajax({
            method:'POST',
            url:'$deleteUrl',
            data:{path:path,_token:"$token"},
            success:function(res) {
                if (res.success) {
                    toastr.success(res.message);
                    $('#input-'+previewId).remove();
                } else
                    toastr.error(res.message);
            }
        });
});
EOT;
    }

    public function fileClear()
    {
        $id = $this->options['id'];
        $hidden = $this->options['hidden'];
        $deleteUrl = !empty($this->options['deleteUrl'])? : url('/admin/delete/image');
        $token = csrf_token();
        return <<<EOT
 $('#$id').on('fileclear',function(){
    var hiddenInputs = $('input[name="$hidden"]')
    $.each(hiddenInputs,function(k,v){ 
        $.ajax({
            method:'POST',
            url:'$deleteUrl',
            data:{path:$(v).val(),_token:"$token"},
            beforeSend:function(){
                 NProgress.start()
            },
            success:function(res) {
                 NProgress.done()
                if (res.success) {
                    toastr.success(res.message);
                    $(v).remove();
                } else
                    toastr.error(res.message);
            }
        });
    });
 });
EOT;

    }

    public function preview($imgs,$configs,$isImage = true)
    {
        $initialPreview = [];
        if ($imgs) {
            foreach ($imgs as $img) {
                if ($isImage) {
                    $initialPreview [] = '<img src="'.$img.'" style="width: 200px;height: 200px;">';
                } else
                    $initialPreview [] = $img;
            }
        }

        $this->options['initialPreview'] = $initialPreview;
        $this->options['initialPreviewConfig'] = $configs;
        return $this;
    }

    public function render()
    {
        $id = $this->options['id'];
        $options = json_encode($this->options,JSON_UNESCAPED_SLASHES);
        $uploadedRender = $this->fileUploaded();
        $successRemoveRender = $this->fileSuccessRemove();
        $clearRender = $this->fileClear();
       return   <<<EOT
$('#$id').fileinput($options);
$uploadedRender
$successRemoveRender
$clearRender
EOT;
    }
}