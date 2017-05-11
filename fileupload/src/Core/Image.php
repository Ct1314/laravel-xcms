<?php

namespace Upload\Core;


/*
* 
* name Image.php
* author Yuanchang
* date 2017.5.1
*/

use Upload\Interfaces\FileUpload;
use Intervention\Image\ImageManagerStatic;

class Image extends FileUpload
{
    public $request;

    public $config;

    public function __construct($request)
    {
        // upload file request
        $this->request = $request;
        // fileupload.php image config
        $this->config = config('fileupload.image');
        config([
            'filesystems.disks.'.$this->config['disk'].'.root' => $this->config['root'],
            'filesystems.disks.'.$this->config['disk'].'.driver' => $this->config['driver'],
            'filesystems.default' => $this->config['disk'],
        ]);
    }
    public function filter()
    {
        $location = $this->config['root'].$this->path;
        $image = ImageManagerStatic::make($location);
        $imageFilter = new ImageFilter($location);
        $image->filter($imageFilter);
        return $imageFilter;
    }
}