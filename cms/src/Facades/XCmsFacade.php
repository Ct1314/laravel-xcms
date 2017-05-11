<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/4/14
 * Time: 16:11
 */

namespace XCms\Facades;


use Illuminate\Support\Facades\Facade;
class XCmsFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return \XCms\XCms::class;
    }
}