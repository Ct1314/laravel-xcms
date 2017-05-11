<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/4/10
 * Time: 11:51
 */

namespace XCms\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class XCmsRouteServiceProvider extends ServiceProvider
{

    public function map()
    {
        require (__DIR__ . '/../web.php');
    }
}