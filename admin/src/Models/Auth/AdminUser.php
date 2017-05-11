<?php

namespace Admin\Models\Auth;


/*
*
* name AdminUser.php
* author Yuanchang
* date  2017.04.23
*/

use Admin\Traits\PermissionTree;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;

class AdminUser extends User
{

    use PermissionTree;

    /**
     * @desc db table name
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * @desc store、update allow fill data
     * @var array
     */
    protected $fillable = [
        'username','password','name','email','avatar'
    ];

    /**
     * @desc hidden field
     * @var array
     */
    protected $hidden = [
        'remember_token'
    ];

    /**
     * @desc user validator rule
     * @var array
     */
    public $rules = [
        'username'=>'required|unique:admin_users|max:190',
        'password'=>'required|confirmed',
        'name'=>'required|max:255',
        'email'=>'required|unique:admin_users|max:40',
    ];

    /**
     * @desc error format message
     * @var array
     */
    public $messages = [
    ];

    /**
     * @name roles
     * @author Yuanchang
     * @since 2017.04.23
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany('Admin\Models\Auth\Role','admin_role_users','user_id','role_id');
    }

    /**
     * @name permissions
     * @author Yuanchang
     * @since 2017.04.23
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany('Admin\Models\Auth\Permission','admin_user_permissions','user_id','permission_id');
    }

    /**
     * @name createUser
     * @author Yuanchang.xu
     * @since 2017
     * @param array $data
     * @param AdminUser $user
     * @return void
     */
    public function createUser(array $data,AdminUser $user = null)
    {
        if ( $user )
        {
            $data ['password'] =  bcrypt($data['password']);

            $user->fill($data)->saveOrFail();

        }
        else
        {
            $this->name     =  $data['name'];
            $this->email    =  $data['email'];
            $this->avatar   =  empty( $data['avatar'] )? null : $data['avatar'];
            $this->password =  bcrypt($data['password']);
            $this->username =  $data['username'];

            $this->saveOrFail();
        }
    }

    /**
     * @name userPermissions
     * @desc get login user permissions
     * @param null $fields
     * @param $update
     * @author Yuanchang
     * @since 2017.04.23
     * @return mixed
     */
    public function userPermissions(AdminUser $user,$fields = null,$update = false)
    {
        // if update user permissions cache
        if (!$update)
        {

            if ( Cache::has($user->id.':permissions') )
            {
                $permissions = json_decode( Cache::get($user->id.':permissions'),true );

                return $fields? array_pluck($permissions,$fields ) : $permissions;
            }
            
        }
        
        // if user is super user
        if ( $user->id == 1 )
        {
            return true;
        }
       

        // get user role information
        $roles = $user->roles;

        // get role permission information
        $permissions = [];

        foreach ($roles as $role)
        {
            $permissions += $role->permissions->toArray();
        }

        // generate current user permissions cache information
        Cache::forever( $user->id.':permissions',json_encode($permissions) );

        return $fields? array_pluck($permissions,$fields ) : $permissions;
    }

    /**
     * @name userMenus
     * @desc get login user menus
     * @author Yuanchang
     * @since 2017.04.23
     * @return mixed
     */
    public function userMenus(AdminUser $user,$update = false)
    {
        // if update user menus cache
        if (!$update)
        {
            if (Cache::has($user->id.':menu'))
            {
                return json_decode( Cache::get($user->id.':menu'),true );
            }
        }

        // if user is super user
        if ( $user->id == 1 )
        {
            return true;
        }
        
        $permissions = $this->userPermissions($user,'id',false);

        // if user permissions is null
        if( !$permissions )
        {
            Cache::forever($user->id.':menu',json_encode([]));

            return [];
        }

        $permissionTrees = $this->permissionTree();

        // generate user menu
        foreach ($permissionTrees as $key => &$permissionTree)
        {
            if ( !empty($permissionTree['child']))
            {

                foreach ($permissionTree['child'] as $subKey => &$subPermissionTree)
                {
                    if ( !in_array($subPermissionTree['id'],$permissions) )
                    {
                        unset($permissionTree['child'][$subKey]);
                    }
                }
            }

        }
        Cache::forever($user->id.':menu',json_encode($permissionTrees));

        return $permissionTrees;
    }

    /**
     * @name administratorMenus
     * @desc get super user menus
     * @author Yuanchang
     * @since 2017.04.23
     * @return array
     */
    public function administratorMenus()
    {
        return $this->permissionTree();
    }

    /**
     * @name deleteUserCache
     * @desc delete user menu cache permission cache
     * @param $id
     * @author Yuanchang
     * @since 2017.04.23
     */
    public function deleteUserCache($id)
    {
        if ( Cache::has($id.':permissions') )
        {
            Cache::forget($id.':permissions');
        }

        if (Cache::has($id.':menu'))
        {
            Cache::forget($id.':menu');
        }
    }
}