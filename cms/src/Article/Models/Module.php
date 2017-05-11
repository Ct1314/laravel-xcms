<?php   namespace XCms\Article\Models;

/*
* name 
* user Yuanchang.xu
* date 2017/4/24
*/


use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use ValidatingTrait;
    /**
     * @var array
     */
    protected $fillable = ['name','slug'];

    public $rules = [
        'name'=>'required|unique:modules',
        'slug'=>'required|unique:modules'
    ];
    public $messages = [

    ];

    public function articles()
    {
        return $this->hasMany('XCms\Article\App\Models\Article','module_id');
    }

}