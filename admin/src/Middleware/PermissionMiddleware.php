<?php

namespace Admin\Middleware;
/*
* name PermissionMiddleware.php
* user Yuanchang.xu
* date 2017/4/27
*/


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class PermissionMiddleware
{
    public function handle(Request $request,Closure $next)
    {
        $routeName = Route::currentRouteName();

        if ( $user = Auth::guard('admin')->user() )
        {
            if ( !Gate::forUser($user)->check($routeName) )
            {
                dd('处理没有权限');
            }

            return $next($request);
        }

    }
}