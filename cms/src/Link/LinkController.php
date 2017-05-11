<?php

namespace XCms\Link;
/*
* name LinkController.php
* user Yuanchang.xu
* date 2017/5/8
*/

use Flash;
use XCms\BaseController;
use Illuminate\Http\Request;
use Watson\Validating\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkController extends BaseController
{
    public function index()
    {
        $links = Links::orderBy('order','desc')->paginate(10);
        return view('link::index',compact('links'));
    }

    public function create()
    {
        return view('link::create');
    }

    public function store(Request $request)
    {
        $linkModel = new Links();
        try {
            $linkModel->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        }
        return redirect(route('links.index'));
    }

    public function edit($id)
    {
        try {
            $link = Links::findOrFail($id);
            return view('link::edit',compact('link'));
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该链接不存在');
            return redirect(route('links.index'));
        }
    }

    public function update($id,Request $request)
    {
        try {
            $link = Links::findOrFail($id);
            $link->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该链接不存在');
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        }
        return redirect(route('links.index'));
    }

    public function destroy($id)
    {
        try {
            $link = Links::findOrFail($id);
            $link->delete();
            Flash::success('删除成功');
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该链接不存在');
        }
        return redirect(route('links.index'));
    }
}