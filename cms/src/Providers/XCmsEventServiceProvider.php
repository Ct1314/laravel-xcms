<?php

namespace XCms\Providers;
/*
* name XCmsEventServiceProvider.php
* user Yuanchang.xu
* date 2017/5/2
*/

use App\Providers\EventServiceProvider;

class XCmsEventServiceProvider extends EventServiceProvider
{

    protected $listen = [
        'XCms\Events\HtmlCacheEvent' => [
            'XCms\Listeners\HtmlCacheListener',
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}