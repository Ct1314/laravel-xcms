<?php

namespace XCms;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller ;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function deleteImageResouce(Request $request)
    {
        $path = $request->get('path');
        if (!$path) {
            return [
                'success'=>false,
                'message'=>'该文件不存在或已经被删除'
            ];
        }
        $deletePath = public_path('/uploads/images').$path;
        if (!app('files')->delete($deletePath)) {
            return [
                'success'=>false,
                'message'=>'删除失败,请稍后再试'
            ];
        }
        return [
            'success'=>true,
            'message'=>'删除成功'
        ];
    }

    public function deleteVideoResouce(Request $request)
    {
        $path = $request->get('path');
        if (!$path) {
            return [
                'success'=>false,
                'message'=>'该文件不存在或已经被删除'
            ];
        }
        $deletePath = public_path('/uploads/videos').$path;
        if (!app('files')->delete($deletePath)) {
            return [
                'success'=>false,
                'message'=>'删除失败,请稍后再试'
            ];
        }
        return [
            'success'=>true,
            'message'=>'删除成功'
        ];
    }
}
