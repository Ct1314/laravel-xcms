<?php

namespace XCms\Page\Controllers;
/*
* name AboutController.php
* user Yuanchang.xu
* date 2017/5/4
*/

use Flash;
use XCms\BaseController;
use XCms\Page\Models\About;
use Illuminate\Http\Request;
use Watson\Validating\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AboutController extends BaseController
{
    public function index()
    {
        $abouts = About::paginate(10);
        return view('page::about.index',compact('abouts'));
    }

    public function create()
    {
        return view('page::about.create');
    }

    public function store(Request $request)
    {
        $aboutModel = new About;
        try {
            $aboutModel->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        }
        return redirect(route('abouts.index'));
    }

    public function edit($id)
    {
        try {
            $about = About::findOrFail($id);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该页面不存在');
            return redirect(route('abouts.index'));
        }
        return view('page::about.edit',compact('about'));
    }

    public function update($id,Request $request)
    {
        try {
            $about = About::findOrFail($id);
            $about->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该页面不存在');
            return redirect(route('abouts.index'));
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        }
        return redirect(route('abouts.index'));
    }

    public function destroy($id)
    {
        try {
            $about = About::findOrFail($id);
            $about->delete();
            Flash::success('删除成功');
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该页面不存在');
            return redirect(route('abouts.index'));
        }
        return redirect(route('abouts.index'));
    }

    public function getBody($id)
    {
        try {

            $about = About::findOrFail($id,['body']);
            return [
                'success'=>true,
                'message'=>'获取成功',
                'data'=>$about
            ];
        } catch(ModelNotFoundException $modelNotFoundException) {
            return [
                'success'=>false,
                'message'=>'没有获取到信息'
            ];
        }
    }
}