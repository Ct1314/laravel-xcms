<?php

namespace Admin\Models\Auth;


/*
* 
* name 
* author Yuanchang
* date 2017/04/21
*/

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * @var string
     */
    protected $table = 'admin_permissions';

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id','name','order','icon','uri'
    ];

    /**
     * @var array
     */
    public $rules = [
        'name'=>'required',
        'order'=>'required|numeric',
        'icon'=>'required',
        'uri'=>'required',
    ];

    /**
     * @var array
     */
    public $messages = [

    ];

    public static function getPermissionsTreeForDb()
    {
        // get permission information form db
        $permissions = Permission::orderBy('order','asc')->get()->toArray();
        $arr = [];

        foreach ($permissions as $top)
        {
            if ($top['parent_id'] == null)
            {
                foreach ($permissions as $sub)
                {
                    if ( $sub['parent_id'] == $top['id'])
                    {
                        $top['child'][] = $sub;
                    }
                }
                $arr [] = $top;
            }
        }
        return $arr;
    }
}