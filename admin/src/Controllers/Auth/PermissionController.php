<?php

namespace Admin\Controllers\Auth;
/*
* name PermissionController.php
* user Yuanchang.xu
* date 2017/4/26
*/

use Flash;
use Throwable;
use Illuminate\Http\Request;
use Admin\Traits\PermissionTree;
use Admin\Models\Auth\Permission;
use Illuminate\Support\Facades\Route;
use Admin\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionController extends BaseController
{
    use PermissionTree;

    public function index()
    {
        $permissions =  $this->permissionTree();
        return view('admin::auth.permission.index',['permissions'=>$permissions]);

    }

    public function create()
    {
        return view('admin::auth.permission.create');
    }

    public function store(Request $request)
    {

        $model = new Permission();

        $validator = Validator::make( $request->all(),$model->rules,$model->messages );

        if ( $validator->fails() )
        {
            return redirect()->back()->withErrors( $validator->errors() );
        }

        if ( !$this->isValidUrl( $request->get('uri') ) )
        {
            return redirect()->back()->withErrors( '输入的路径无效' );
        }

        if (empty($request->get('parent_id')))
        {
            $request->offsetUnset('parent_id');
        }

        try {

            $model->fill($request->all())->saveOrFail();

            $this->updatePermissionTree();

            Flash::success('保存成功');

        } catch (Throwable $throwable) {

           Flash::error( '保存失败' );

        }

        return redirect()->back();
    }

    public function edit($id)
    {

        try {

            $permissions =  $this->permissionTree();
            $permission = Permission::find($id);

        } catch (ModelNotFoundException $exception) {

            Flash::warning('该权限信息不存在或已经被删除');

            return redirect( route( 'permissions.index' ) );

        }

        return view('admin::auth.permission.edit',['permission'=>$permission,'permissions'=>$permissions]);

    }

    public function update($id,Request $request)
    {

        $inputs = $request->all();

        $model = new Permission();

        try {

            $children = $this->subPermission( $model->all()->toArray(),$id,'id');

            $permission = Permission::find($id);

        } catch (ModelNotFoundException $exception) {

            Flash::warning('该权限信息不存在或已经被删除');
            return redirect( route( 'permissions.index' ) );

        }

        if ( !$this->isValidUrl( $inputs['uri'] ) )
        {
            return redirect()->back()->withErrors('输入的路径不无效');
        }

        if ( $inputs['parent_id'] == $id || in_array($inputs['parent_id'], $children) )
        {
            return redirect()->back()->withErrors('选择父级菜单错误:不能将下级或自身作为父级菜单');
        }

        if ( empty($inputs['parent_id']) )
        {
            unset($inputs['parent_id']);
        }

        if ( $permission->fill( $inputs )->save() )
        {

            $this->updatePermissionTree();

            Flash::success('修改成功');
            return redirect( route( 'permissions.index' ) );

        }

        return redirect()->back()->withErrors($permission->getErrors());
    }

    public function destroy($id)
    {
        try {

            $permission = Permission::find($id);

            $permission->delete();

            $this->updatePermissionTree();

            Flash::success('删除成功');

        } catch (ModelNotFoundException $modelNotFoundException ) {

            Flash::warning('该权限不存在或已被删除');

        }

        return redirect( route('permissions.index') );
    }

    public function tree()
    {
        $permissions = Permission::orderBy('order','asc')->get();

        return $permissions;
    }

    public function isValidUrl($uri)
    {
        return Route::has($uri);
    }
}