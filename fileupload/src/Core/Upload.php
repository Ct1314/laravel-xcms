<?php

namespace Upload\Core;
/*
* name FileUpload.php
* user Yuanchang.xu
* date 2017/5/4
*/


use Upload\Interfaces\FileUpload;
use Upload\Exceptions\FileUploadException;

class Upload
{
    public $path;

    public $upload;

    protected $request;

    protected $config;

    protected $clientOriginalName;

    protected $clientOriginalExtension;

    public function __construct(FileUpload $upload)
    {
        $this->config = $upload->config;
        $this->request = $upload->request;
        $this->clientOriginalExtension = $upload->request->getClientOriginalExtension();
        $this->clientOriginalName = $upload->request->getClientOriginalName();
    }

    public function hashName()
    {
        $hashType = $this->config['hashType'];

        return $hashType( $this->clientOriginalName );
    }

    public function setSavePath()
    {

        return DIRECTORY_SEPARATOR.date('Ym').DIRECTORY_SEPARATOR;
    }

    public function setSaveName()
    {
        if ($this->config['hash'] ) {
            return $this->hashName().'.'.$this->clientOriginalExtension;
        }
        return $this->clientOriginalName;
    }

    public function save()
    {
        $check = new Check($this->request,$this->config);
        if ($check->error) {
            throw new FileUploadException( $check->error );
        }
        $path = $this->setSavePath();
        $name = $this->setSaveName();
        $this->path = $path.$name;
        $this->request->storeAs($path,$name);
        return $this;
    }
}