<?php  
 namespace XCms\Link; 

/*
* name 
* user Yuanchang.xu
* date 2017/5/8
*/


use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use ValidatingTrait;

    protected $fillable = [
        'name',
        'url',
        'order',
        'description'
    ];

    public $rules = [
        'name'=>'required',
        'url'=>'required|url',
        'order'=>'numeric',
    ];

}