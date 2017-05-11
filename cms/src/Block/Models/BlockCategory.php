<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/4/11
 * Time: 9:38
 */

namespace XCms\Block\Models;

use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;

class BlockCategory extends Model
{
    // validator trait
    use ValidatingTrait;

    protected $table = 'blocks_categories';  // table name

    // fill fields
    protected $fillable = [
        'name','slug','title','details','status'
    ];

    // validator rules
    protected $rules = [
        'name'=>'required',
        'slug'=>'required|unique:blocks_categories',
        'title'=>'required'
    ];
    // validator messages
    protected $messages = [
    ];

    /**
     * @name blocks
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @return mixed
     */
    public function blocks()
   {
       return $this->hasMany(Block::class,'category_id');
   }

}