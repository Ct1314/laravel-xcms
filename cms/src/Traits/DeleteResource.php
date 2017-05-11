<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/5/2
 * Time: 11:34
 */

namespace XCms\Traits;


use Illuminate\Support\Facades\Storage;

trait DeleteResource
{
    public function delete($type,$path)
    {
        switch ($type) {
            case 'image':
                $this->image($path);
                break;
            case 'video':
                $this->video($path);
                break;
            case 'html':
                $this->html($path);
        }
    }
    public function image($path)
    {
        $publicPath = public_path('/uploads/images');
        if (is_array($path)) {
            foreach ($path as $val) {
                $path = $publicPath.$val;
                app('files')->delete($path);
            }
        }
        else
            app('files')->delete($publicPath.$path);
    }
    public function video($path)
    {
        $publicPath = public_path('/uploads/videos');
        if (is_array($path)) {
            foreach ($path as $val) {
                $path = $publicPath.$val;
                app('files')->delete($path);
            }
        }
        else
            app('files')->delete($publicPath.$path);
    }
    public function html( $id )
    {
        $htmlFile = config('xcms.html.prefix').$id.config('xcms.html.ext');

        if ( Storage::disk(config('xcms.html.disk'))->exists($htmlFile) )
        {
            Storage::disk(config('xcms.html.disk'))->delete($htmlFile);
        }
    }
}