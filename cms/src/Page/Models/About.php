<?php

namespace XCms\Page\Models;
/*
* name About.php
* user Yuanchang.xu
* date 2017/5/4
*/

use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use ValidatingTrait;

    protected $fillable = [
      'slug','name','body'
    ];

    public $rules = [
        'slug'=>'required|unique:abouts',
        'name'=>'required'
    ];
}