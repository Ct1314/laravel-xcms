<?php
namespace XCms\Article\Controllers;

/*
* name ModuleController.php
* user Yuanchang.xu
* date 2017/4/24
*/

use Flash;
use Exception;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Article\Models\Module;
use Watson\Validating\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModuleController extends BaseController
{

    public function index()
    {
        $modules = Module::paginate(10);
        return view('article::module.index',compact('modules'));
    }


    public function create()
    {
        return view('article::module.create');
    }

    public function store(Request $request)
    {
        $m = new Module();
        try {
            $m->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
        } catch ( ValidationException $exception ) {
            return redirect(route('modules.create'))->withErrors($exception->getErrors());
        }
        return redirect(route('modules.index'));
    }

    public function edit($id)
    {
        try{
            $module = Module::findOrFail($id);
            return view('article::module.edit',compact('module'));
        }catch ( ModelNotFoundException $exception ) {
            Flash::warning('该模型不存在');
            return redirect(route('modules.index'));
        }
    }

    public function update($id,Request $request)
    {
        try{

            $module = Module::findOrFail($id);
            $module->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
        }catch (ModelNotFoundException $exception) {
            Flash::warning('该模型不存在');
        }catch (ValidationException $exception) {
            return redirect( route('modules.edit',$id) )->withErrors($module->errors());
        }
        return redirect(route('modules.index'));

    }
    public function destroy($id)
    {
        try{
            $module = Module::findOrFail($id);
            $module->delete();
            Flash::success('模型删除成功');
        }catch (ModelNotFoundException $exception) {
            Flash::warning('模型没找到');
        }catch (Exception $exception) {
            Flash::warning('删除失败');
        }
        return redirect(route('modules.index'));
    }
}
