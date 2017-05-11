<?php

/*
*
* name fileupload.php
* author Yuanchang
* date 2017/5/2
*/

return [

    'disks' => [
        'upload'=>[
            'driver' => 'local',
        ]
    ],
    'video' => [
        'disk'          =>'upload',
        'driver'        =>'local',
        'root'          => public_path('uploads/videos'),
        'hash'          => true,
        'hashType'      => 'md5',
        'previewimg'    =>  true,
        'previewimgtime'=>  10,
        'allow'     => ['avi','mp4','mpeg','wmv','mp4','rm','rmvb','3gp','flv','mkv','mov'],
        'maxsize'       => 1024*100,
    ],

    'image' => [
        'watermark'     =>  true,
        'watermarkdir'  =>  '',
        'hash'          =>  true,
        'hashType'      =>  'md5',
        'allow'         =>  ['jpg','jpeg','gif','png'],
        'maxsize'       =>  2048,
        'root'          =>  public_path('uploads/images'),
        'disk'          =>  'upload',
        'driver'        =>  'local',
    ]
];