<?php

namespace Upload\Core;


/*
* 
* name Video.php
* author Yuanchang
* date 2017.5.1
*/

use Upload\Interfaces\FileUpload;

class Video extends FileUpload
{
    public $request;

    public $config;

    public function __construct($request)
    {
        // upload file request
        $this->request = $request;
        // fileupload.php image config
        $this->config = config('fileupload.video');
        config([
            'filesystems.disks.'.$this->config['disk'].'.root' => $this->config['root'],
            'filesystems.disks.'.$this->config['disk'].'.driver' => $this->config['driver'],
            'filesystems.default' => $this->config['disk'],
        ]);
    }
}