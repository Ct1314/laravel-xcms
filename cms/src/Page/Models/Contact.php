<?php  
 namespace XCms\Page\Models;

/*
* name 
* user Yuanchang.xu
* date 2017/5/4
*/

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
class Contact extends Model
{
    use ValidatingTrait;

    protected $fillable = [
        'slug', 'name', 'body','mobile','email','tel','wx','qq'
    ];

    public $rules = [
        'slug'=>'required|unique:contacts',
        'body'=>'required',
        'mobile'=>'required',
        'tel'=>'required',
    ];
}