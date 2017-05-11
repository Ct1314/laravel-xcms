<?php

namespace Admin\Traits;


/*
* 
* name PermissionTree.php
* author Yuanchang
* date 2017/04/23
*/

use Admin\Models\Auth\Permission;
use Illuminate\Support\Facades\Cache;

trait PermissionTree
{
    public function permissionTree()
    {

        // try get  permission information from the cache
        if ( Cache::has('permissions') )
        {
            return json_decode( Cache::get('permissions'),true );
        }
        $permissions = Permission::getPermissionsTreeForDb();

        // generate permission information to cache
        Cache::forever('permissions',json_encode($permissions) );

        return $permissions;
    }

    public function updatePermissionTree()
    {

        $permissions = Permission::getPermissionsTreeForDb();
        // generate permission information to cache
        Cache::forever('permissions',json_encode($permissions) );

        return $permissions;
    }

    public function destroyPermissionTree()
    {
        // try get  permission information from the cache
        if ( Cache::has('permissions') )
        {
            return Cache::forget('permissions');
        }
    }

    public function subPermission(array $permissions,$parent_id,$fields = null)
    {
        static $arr = [];

        foreach ($permissions as $permission)
        {
            if ($permission['parent_id'] == $parent_id)
            {
                $arr [] = $permission;

                $this->subPermission($permissions,$permission['id']);
            }
        }

       return $fields? array_pluck($arr,$fields) : $arr;
    }
}