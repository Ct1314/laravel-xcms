<?php

namespace Admin\Controllers\Auth;
/*
* name UserController.php
* user Yuanchang.xu
* date 2017.04.23
*/


use Flash;
use Throwable;
use Admin\Models\Auth\Role;
use Illuminate\Http\Request;
use Admin\Traits\PermissionTree;
use Admin\Events\UserCacheEvent;
use Admin\Models\Auth\AdminUser;
use Admin\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends BaseController
{

    use PermissionTree;

    /**
     * @name index
     * @desc show users list
     * @author Yuanchang.xu
     * @since 2017.04.23
     * @return mixed
     */
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('admin::auth.user.index',['users'=>$users]);
    }

    /**
     * @name create
     * @desc show user create form
     * @author Yuanchang.xu
     * @since 2017.04.23
     * @return mixed
     */
    public function create()
    {
        $roles = Role::get(['id','name']);

        $permissions = $this->permissionTree();

        return view('admin::auth.user.create',compact('roles','permissions'));
    }

    /**
     * @name store
     * @desc create user information and user cache
     * @author Yuanchang.xu
     * @since 2017.04.23
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // validator data
        $model = new AdminUser();

        $validator = Validator::make($request->all(),$model->rules,$model->messages);

        if( $validator->fails() )
        {
            return redirect( route('users.create') )->withErrors( $validator->errors() );
        }

        try {

            // create user to db
            $model->createUser( $request->all() );

            // create user roles to db
            if( $request->get('role_id') )
            {
                $model->roles()->sync( $request->get('role_id') );
            }

            // create user permissions to db
            if( $request->get('permission_id') )
            {
                $model->permissions()->sync( $request->get('permission_id') );
            }

            // generator user permissions cache and menus cache
            event(new UserCacheEvent($model));

            Flash::success('保存成功');

        } catch (Throwable $exception) {

            Flash::error('保存失败');

        }
        return redirect( route('users.index') );
    }

    /**
     * @name edit
     * @desc show edit user form
     * @author Yuanchang.xu
     * @since 2017.04.23
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        try {

            // get edit user information
            $user = AdminUser::findOrFail($id);

            // get user roles information
            $roles = Role::get(['id','name']);

            // get permissions information
            $permissions = $this->permissionTree();

            // get user permissions id column
            $user_permissions = $user->permissions()->pluck('permission_id')->toArray();

            // get user roles id column
            $user_roles = $user->roles()->pluck('role_id')->toArray();

            return view('admin::auth.user.edit',compact('user','roles','permissions','user_roles','user_permissions'));

        } catch (ModelNotFoundException $exception) {

            Flash::warning('该用户不存在或已被删除');

            return redirect( route('users.index') );

        }
    }

    /**
     * @name update
     * @desc update user information and user cache
     * @param $id
     * @param Request $request
     * @author Yuanchang
     * @since 2017.04.23
     * @return mixed
     */
    public function update($id, Request $request)
    {


        try {

            // get update user information
            $user = AdminUser::findOrFail($id);

            // validator update data
            $validator = Validator::make($request->all(),$user->rules,$user->messages);

            if( $validator->fails() )
            {
                return redirect( route('users.edit',$id) )->withErrors( $validator->errors() );
            }

            // update user to db
            $user->createUser( $request->all(),$user );

            // update user roles  or delete user roles to db
            if( $request->get('role_id') )
            {
                $user->roles()->sync( $request->get('role_id') );
            }
            else
            {
                $user->roles()->detach( );
            }
            // update user permissions  or delete user permissions
            if( $request->get('permission_id') )
            {
                $user->permissions()->sync( $request->get('permission_id') );
            }
            else
            {
                $user->permissions()->detach( );
            }

            // generate user permission cache and menu cache
            event(new UserCacheEvent($user));


            Flash::success('修改成功');


        }catch (ModelNotFoundException $notFoundException) {

            Flash::warning('该用户不存在或已经被删除');

        }catch (Throwable $throwable) {

            Flash::error('保存失败');

        }

        return redirect( route('users.index') );
    }

    /**
     * @name destroy
     * @desc delete user information and user cache
     * @param $id
     * @author Yuanchang
     * @since 2017.04.23
     * @return mixed
     */
    public function destroy($id)
    {
        try {

            // get user to db
            $user = AdminUser::findOrFail($id);

            // delete user
            $user->delete();

            // delete user all cache
            $user->deleteUserCache($id);

            Flash::success('删除成功');

        } catch (ModelNotFoundException $modelNotFoundException) {

            Flash::warning('该用户不存在或已经被删除');

        }

        return redirect( route('users.index') );
    }
}