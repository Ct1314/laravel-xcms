<?php  
 namespace XCms\Article\Models;

/*
* name 
* user Yuanchang.xu
* date 2017/4/25
*/

use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;

class Property extends Model {

    use ValidatingTrait;

    protected $fillable = [
        'name','order'
    ];

    public $rules = [
        'name'=>'required|unique:properties',
        'order'=>'numeric'
    ];

    public $messages = [
        'name.required'=>'文章属性不能为空',
        'name.unique'=>'文章属性已经存在',
        'order.numeric'=>'排序值必须是数字',
    ];

    public function articles()
    {
        $this->belongsToMany('XCms\Article\Models\Article','article_properties','property_id','article_id');
    }
}