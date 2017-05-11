<?php

namespace Upload\Core;


/*
* 
* name CheckImage.php
* author Yuanchang
* date 2017/5/2
*/
use Upload\Interfaces\FileCheck;

class Check implements FileCheck
{

    public $error;

    protected $config;

    protected $request;

    public function __construct($request,$config)
    {
        $this->handle($request,$config);
    }

    public function handle($request,$config)
    {
        $this->request = $request;
        $this->config = $config;
        $this->checkSize()->checkExt();
    }

    public function checkSize()
    {
        $maxSize = $this->config['maxsize'];
        if (($this->request->getClientSize()/1024) > $maxSize ) {
            $this->error = '超出大小限制';
        }
        return $this;
    }

    public function checkExt()
    {
        $ext = $this->config['allow'];
        if (!in_array( $this->request->getClientOriginalExtension(), $ext)) {
            $this->error = '不允许这个文件类型上传';
        }
        return $this;
    }
}