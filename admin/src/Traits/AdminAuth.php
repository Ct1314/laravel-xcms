<?php

namespace Admin\Traits;
/*
* 
* name AdminAuthe.php
* author Yuanchang
* date ${DATA}
*/

use Illuminate\Http\Request;
use Admin\Models\Auth\AdminUser;
use Admin\Models\Auth\Permission;
use Illuminate\Support\Facades\Gate;

trait AdminAuth
{


    /**
     * @name before
     * @desc before define permission check current user if super user
     * @author Yuanchang
     * @since 2017.04.23
     */
    public function before()
    {
        Gate::before(function ($user) {

            return $this->isAdministrator($user);

        });
    }

    /**
     * @name define
     * @desc define permission and check it
     * @author Yuanchang
     * @since 2017.04.
     */
    public function define()
    {
        $permissions = Permission::all();

        collect($permissions)->each( function ($permission) {

            $this->check($permission->uri);

        });

    }

    /**
     * @name check
     * @desc
     * @param $permission
     * @author Yuanchang
     * @since 2017.04.
     */
    public function check($permission )
    {
        Gate::define($permission,function ( $user ) use ($permission) {

           return in_array($permission,$user->userPermissions($user,'uri',false));

        });
    }


    /**
     * @name allow
     * @desc
     * @param $permission
     * @author Yuanchang
     * @since 2017.04.
     */
    public function allow($permission)
    {

    }

    /**
     * @name deny
     * @desc
     * @param $permission
     * @author Yuanchang
     * @since 2017.04.
     */
    public function deny($permission)
    {

    }

    /**
     * @name inRoles
     * @desc
     * @param AdminUser $user
     * @author Yuanchang
     * @since 2017.04.
     */
    public function inRoles(AdminUser $user)
    {

    }

    /**
     * @name isRole
     * @desc
     * @param AdminUser $user
     * @param $slug
     * @author Yuanchang
     * @since 2017.04.
     */
    public function isRole(AdminUser $user, $slug)
    {

    }

    /**
     * @name isAdministrator
     * @desc
     * @param AdminUser $user
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function isAdministrator(AdminUser $user)
    {
        if ($user->id == 1 || $user->name == 'administrator' ) return true;
    }

    /**
     * @name isArtisan
     * @desc
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function isArtisan()
    {
        $request = new Request;

        if ( $request->getScriptName() === 'artisan')  return true;
    }

}