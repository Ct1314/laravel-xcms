<?php

namespace XCms\Article\Controllers;
/*
* name PropertyController.php
* user Yuanchang.xu
* date 2017/4/25
*/

use Flash;
use ErrorException;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Article\Models\Property;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PropertyController extends BaseController
{
    public function index()
    {
        $properties = Property::orderBy('order','desc')->paginate(10);

        return view('article::property.index')->with('properties',$properties);
    }

    public function create()
    {
        return view('article::property.create');
    }

    public function store(Request $request)
    {
        $proModel = new Property();

        if( !$proModel->fill($request->all())->save() )
        {
            return redirect()->back()->withErrors($proModel->getErrors())->withInput();
        }

        Flash::success('保存成功');

        return redirect(route('properties.index'));
    }

    public function edit($id)
    {
        try {

            $property = Property::findOrFail($id);

            return view('article::property.edit',['property'=>$property]);

        } catch (ModelNotFoundException $e) {

            Flash::warning('该属性不存在');

        } catch (ErrorException $e) {
            Flash::warning('系统异常');

        }
        return redirect(route('properties.index'));
    }

    public function update($id,Request $request)
    {
        try {

            $property = Property::find($id);

            if( !$property->fill($request->all())->save() )
            {
                return redirect()->back()->withErrors($property->getErrors())->withInput();
            }
            Flash::success('保存成功');
        } catch (ModelNotFoundException $e) {

            Flash::warning('该属性不存在');

        } catch (ErrorException $e) {
            Flash::warning('保存失败');
        }
        return redirect(route('properties.index'));
    }

    public function destroy($id)
    {
        try {

            $property = Property::find($id);

            $property->delete();

            Flash::success('删除成功');

        } catch (ModelNotFoundException $e) {

            Flash::warning('该属性不存在');

        } catch (ErrorException $e) {

            Flash::warning('保存失败');
        }
        return redirect(route('properties.index'));
    }
}