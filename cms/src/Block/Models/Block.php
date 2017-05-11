<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/4/11
 * Time: 13:09
 */

namespace XCms\Block\Models;

use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use ValidatingTrait;

    // fill data
    protected $fillable = [
      'category_id','name','url','order','description','image','images','slug','status'
    ];

    // validator rules
    protected $rules = [
        'name'=>'required',
        'slug'=>'required|unique:blocks',
        'order'=>'numeric',
        'category_id'=>'required'
    ];

    // validator messages
    protected $messages = [

    ];
}