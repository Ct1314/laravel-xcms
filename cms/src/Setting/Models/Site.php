<?php namespace XCms\Setting\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class Site extends Model
{
    use ValidatingTrait;

    protected $table = 'site';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id','icp','status','close_cause','copyright',
    ];

    protected $rules = [
        'icp'=>'required',
        'copyright'=>'required',
        'status'=>'required',
        'copyright'=>'required'
    ];
}