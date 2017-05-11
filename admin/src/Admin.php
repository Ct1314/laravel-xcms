<?php

namespace Admin;
/*
* name Admin.php
* user Yuanchang.xu
* date 2017/5/3
*/

use Closure;
use Admin\Form\FileInput;

class Admin
{
    public function __construct()
    {

    }

    public function FileInput(array $options,Closure $render)
    {
        return call_user_func( $render, new FileInput($options) );
    }
}