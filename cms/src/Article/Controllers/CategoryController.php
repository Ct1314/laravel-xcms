<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/4/13
 * Time: 13:46
 */

namespace XCms\Article\Controllers;


use Flash;
use Validator;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Article\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends BaseController
{

    /**
     * @name index
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if($request->isMethod('POST'))
        {
            return Category::all();
        }

        $categories = Category::all();

        return view('article::category.index')->with('catetgories',$categories);
    }

    /**
     * @name create
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @return mixed
     */
    public function create()
    {
        $categories = Category::orderBy('lft','desc')->get();

        return view('article::category.create')->with('categories',$categories);
    }

    /**
     * @name store
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        $inputs = $request->all();

        $model = new Category();

        if(!$model->fill($inputs)->save())
        {
            return redirect()->back()->withErrors($model->getErrors())->withInput();
        }
        Flash::success('保存成功');
        return redirect(route('categories.index'));
    }

    /**
     * @name storeSub
     * @desc 添加下级分类
     * @author Yuanchang.xu
     * @since 2017
     * @param Request $request
     * @return mixed
     */
    public function storeSub($id,Request $request)
    {
        try {

            $category = Category::findOrFail($id);

        } catch (ModelNotFoundException $exception) {

            return response()->json(['success'=>false,'message'=>'该分类不存在']);
        }
        $validator = Validator::make($request->all(),$category->rules);

        if( $validator->passes() )
        {
            $category->children()->create($request->all());

            return response()->json(['success'=>true,'message'=>'添加成功']);
        }

        return response()->json(['success'=>false,'message'=>'添加失败']);

    }

    /**
     * @name update
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request,$id)
    {
        $category = Category::find($id);

        if(!$category)
        {
            return response()->json(['success'=>false,'message'=>'该分类不存在']);
        }

        if($category->fill($request->all())->save())
        {
            return response()->json(['success' => true, 'message' => '保存成功']);
        }

        return response()->json(['success'=>false,'message'=>$category->getErrors()->first()]);
    }

    /**
     * @name destroy
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category)
        {
            return response()->json(['success'=>false,'message'=>'该分类不存在']);
        }

        $category->delete();

        return response()->json(['success'=>true,'message'=>'删除成功']);
    }

    /**
     * @name all
     * @desc 获取所有文章分类
     * @author Yuanchang.xu
     * @since 2017
     * @return mixed
     */
    public function all()
    {
        return Category::orderBy('lft','desc')->get();
    }
}