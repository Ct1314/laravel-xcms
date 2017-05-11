<?php

namespace Admin\Controllers\Auth;

/*
* name RoleController.php
* user Yuanchang.xu
* date 2017.04.23
*/

use Admin\Events\UserCacheEvent;
use Flash;
use Admin\Models\Auth\Role;
use Illuminate\Http\Request;
use Admin\Traits\PermissionTree;
use Admin\Controllers\BaseController;
use Watson\Validating\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends BaseController
{
    use PermissionTree;

    /**
     * @name index
     * @desc
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function index()
    {

        $roles = Role::paginate(10);

        return view('admin::auth.role.index',['roles'=>$roles]);
    }

    /**
     * @name create
     * @desc
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function create()
    {
        // get permission information
        $permissions = $this->permissionTree();

        return view('admin::auth.role.create',['permissions'=>$permissions]);
    }

    /**
     * @name store
     * @desc
     * @param Request $request
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function store(Request $request)
    {
        $model = new Role;


        try {

            $model->fill( $request->all() )->saveOrFail();

            if ($request->get('permission_id'))
            {
                $model->permissions()->sync($request->get('permission_id'));
            }

            Flash::success('保存成功');

            return redirect( route( 'roles.index' ) );

        }catch (ValidationException $exception) {

            return redirect( route('roles.create') )->withErrors( $exception->getErrors() );
        }

    }

    /**
     * @name edit
     * @desc
     * @param $id
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function edit($id)
    {
        try {

            $role = Role::findOrFail($id);

            $permissions = $this->permissionTree();

            $role_permissions = $role->permissions()->pluck('permission_id')->toArray();

            return view('admin::auth.role.edit',['role'=>$role,'permissions'=>$permissions,'role_permissions'=>$role_permissions]);

        }catch (ModelNotFoundException $modelNotFoundException) {

            Flash::warning('该角色不存在或已经被删除');

            return redirect( route('roles.index') );

        }

    }

    /**
     * @name update
     * @desc
     * @param $id
     * @param Request $request
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function update($id, Request $request)
    {
        try {

            $role = Role::findOrFail($id);

            $role->fill( $request->all() )->saveOrFail();

            if ( $request->get( 'permission_id' ) )
            {
                $role->permissions()->sync($request->get('permission_id'));
            }
            else
            {
                $role->permissions()->detach();
            }

            collect($role->users)->each(function($user){

                // generator user permissions cache and menus cache
                event(new UserCacheEvent($user));

            });

            Flash::success('保存成功');

            return redirect( route('roles.index') );

        } catch (ModelNotFoundException $modelNotFoundException) {

            Flash::warning('该角色不存在或已经被删除');

            return redirect( route('roles.index') );

        }catch (ValidationException $validationException) {

            return redirect( route('roles.edit',$id) )->withErrors( $validationException->getErrors() );

        }
    }

    /**
     * @name destroy
     * @desc
     * @param $id
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function destroy($id)
    {
        try {

            $role = Role::findOrFail($id);

            $role->delete();

            Flash::success('删除成功');

        }catch (ModelNotFoundException $modelNotFoundException) {

            Flash::warning('该角色不存在或已经被删除');

        }
        return redirect( route('roles.index') );
    }
}