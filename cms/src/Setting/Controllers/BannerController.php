<?php

namespace XCms\Setting\Controllers;


/*
* 
* name BannerController.php
* author Yuanchang
* date 2017/04/23
*/

use Flash;
use Breadcrumbs;
use Exception;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Config\Models\Banner;
use XCms\Core\Services\ImageService;
use XCms\Core\Exception\XCmsException;
use Illuminate\Support\Facades\Storage;

class BannerController extends BaseController
{
    public function __construct()
    {
        Breadcrumbs::register('banner',function($breadcrumbs){
            $breadcrumbs->parent('admin');
            $breadcrumbs->push('轮播图',route('admin.banner.index'));
        });

        parent::breadrumbs();
    }

    /**
     * @name index
     * @desc
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function index()
    {

        $banners = Banner::orderBy('order','desc')->skip(0)->take(5)->get();
        return view('config::banner.index',['banners'=>$banners]);
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
        Breadcrumbs::register('banner.create',function($breadcrumbs){
            $breadcrumbs->parent('banner');
            $breadcrumbs->push('轮播图设置',route('admin.banner.create'));
        });
        return view('config::banner.create');
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
        $bannerModel = new Banner();

        $bannerModel->storeBanner($request->all());

        try{
            Flash::success('保存成功');
        }catch (XCmsException $e){
            Flash::error($e->getMessage());
        }catch (Exception $e){
            Flash::error('保存失败');
        }
        return redirect(route('admin.banner.index'));

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
        $banner = Banner::find($id);

        if(!$banner)
        {
            Flash::warning('该轮播图不存在');
            return redirect(route('admin.banner.index'));
        }
         Breadcrumbs::register('banner.edit',function($breadcrumbs) use($id) {
             $breadcrumbs->parent('banner');
             $breadcrumbs->push('修改',route('admin.banner.edit',$id));
         });
        return view('config::banner.edit',['banner'=>$banner]);

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
        $bannerModel = new Banner();

        try{

            $bannerModel->storeBanner($request->all(),$id);
            Flash::success('保存成功');

        }catch (XCmsException $e) {

            Flash::error($e->getMessage());

            return redirect(route('admin.banner.edit',$id));

        }catch (Exception $e) {

            Flash::error('保存失败');

        }

        return redirect(route('admin.banner.index'));

    }

    /**
     * @name destroy
     * @desc
     * @author Yuanchang
     * @since 2017.04.
     */
    public function destroy()
    {

    }

    /**
     * @name uploadImage
     * @desc
     * @param Request $request
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function uploadImage(Request $request)
    {
        $image = new ImageService($request->file('file'));
        $path = $image->save()->path;
        return ['message'=>'上传成功','path'=>$path];
    }

    /**
     * @name deleteImage
     * @desc
     * @param Request $request
     * @author Yuanchang
     * @since 2017.04.
     * @return mixed
     */
    public function deleteImage(Request $request)
    {
        $banner = Banner::find($request->input('id'));

        if(!$banner)
        {
            return response()->json(['success'=>false,'message'=>'删除失败']);
        }
        if(!Storage::delete($request->input('path')))
        {
            return response()->json(['success'=>false,'message'=>'删除失败,该图片不存在']);
        }

        $banner->banner = null; $banner->save();

        return response()->json(['success'=>true,'message'=>'删除成功','data'=>$banner]);

    }

}