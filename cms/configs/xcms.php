<?php
return [
    'html' => [
        'disk'=>'html',
        'driver'=>'local',
        'root'=>storage_path('app/html/'),
        'prefix'=>'article',
        'ext'=>'.html',
        'variable'=>'art',
        'view' => 'template.video.newdetail',
    ],
    'basic'=>[
        'font-size'=>'14px',
        'font-family'=>'微软雅黑',
        'logo'=>'',
        'icon'=>'',
        'article_default_image'=>'',
        'block_default_image'=>'',
    ],
    'seo'=>[
        'open_seo'=>true,
        'keyword'=>'',
        'description'=>'',
    ],
    'upload'=>[

    ],
    'img'=>[
        'url'=> '/uploads/images'
    ],
    'video'=>[
        'url'=> '/uploads/videos'
    ]
];
