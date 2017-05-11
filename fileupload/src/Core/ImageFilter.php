<?php

namespace Upload\Core;


/*
* 
* name ImageFilter.php
* author Yuanchang
* date 2017/5/2
*/

use Intervention\Image\Filters;

class ImageFilter implements Filters\FilterInterface
{
    protected $image;

    protected $location;

    public function __construct($location)
    {
        $this->location = $location;
    }

    public function applyFilter(\Intervention\Image\Image $image)
    {
        $this->image = $image;
    }

    public function pixel($size)
    {
        $this->image->pixelate($size);
        $this->image->save($this->location);
        return $this;
    }

    public function cut($w,$h)
    {
        $img = $this->image->resize($w,$h);
        $img->save($this->location);
        return $this;
    }

    public function watermark()
    {

    }
}