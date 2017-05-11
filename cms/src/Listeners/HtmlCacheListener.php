<?php

namespace XCms\Listeners;
/*
* name HtmlCacgeListener.php
* user Yuanchang.xu
* date 2017/5/2
*/

use Exception;
use XCms\Events\HtmlCacheEvent;
use Illuminate\Support\Facades\Storage;

class HtmlCacheListener
{
    public function handle(HtmlCacheEvent $event)
    {
        $article = $event->article;
        $config = config('xcms.html');
        config([
            'filesystems.disks.'.$config['disk'].'.driver'=>$config['driver'],
            'filesystems.disks.'.$config['disk'].'.root'=>$config['root'],
        ]);
        $file = $config['prefix'].$article->id.$config['ext'];
        if (Storage::disk(config('xcms.html.disk'))->exists($file)){
            Storage::disk(config('xcms.html.disk'))->delete($file);
        }
        $view = $config['view'];
        $variable = $config['variable'];
        try {
            $html = view($view,[$variable =>$article])->__toString();
        }catch (Exception $exception) {
            throw new Exception ('生成静态页面失败,视图模板不存在');
        }
        Storage::disk($config['disk'])->put($file,$html);

        return $html;
    }
}