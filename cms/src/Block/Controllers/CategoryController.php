<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/4/10
 * Time: 14:57
 */

namespace XCms\Block\Controllers;

use Flash;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Block\Models\BlockCategory;
use Watson\Validating\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends BaseController
{

    public function index()
    {
        $categories = BlockCategory::paginate(10); // 分类
        return view('block::category.index',['categories'=>$categories]);
    }

    public function create()
    {
        return view('block::category.create');
    }

    public function store(Request $request)
    {
        $m = new BlockCategory();
        try {

            $m->fill( $request->all() )->saveOrFail();

            Flash::success('保存成功');

        } catch (ValidationException $validationException) {

            return redirect( route('blockCategories.create') )->withErrors( $validationException->getErrors() );

        }

        return redirect( route('blockCategories.index') );
    }
    public function edit($id)
    {
        try {

            $category = BlockCategory::findOrFail($id);

        } catch (ModelNotFoundException $modelNotFoundException) {

            Flash::warning('该分类不存在');

            return redirect(route('blockCategories.index'));
        }
        return view('block::category.edit',['category'=>$category]);
    }

    public function update(Request $request,$id)
    {
        try{

            $block = BlockCategory::findOrFail($id);

            $block->fill($request->all())->saveOrFail();

            Flash::success('保存成功');
        } catch ( ModelNotFoundException $modelNotFoundException ) {

            Flash::warning('该分类不存在');

        } catch (ValidationException $validationException) {

            return redirect( route('blockCategories.edit',$id) )->withErrors($validationException->getErrors());
        }
        return redirect( route('blockCategories.index') );
    }

    public function destroy($id)
    {

        try {
            BlockCategory::findOrFail($id)->delete();
            Flash::success('删除成功');
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该分类不存在');
        } catch (Exception $exception) {
            Flash::error('删除失败');
        }
        return redirect( route('blockCategories.index') );
    }
}