<?php

namespace Admin\Middleware;
/*
* name MenuMiddleware.php
* user Yuanchang.xu
* date 2017/4/28
*/

use Closure;
use Admin\Traits\AdminAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MenuMiddleware
{
    use AdminAuth;

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();

        if ( !$user )
        {
            return redirect( route('admin.login') );
        }

        if ($this->isAdministrator($user))
        {
            $permissions = $user->administratorMenus();
        }
        else
        {
            $permissions = $user->userMenus($user,false);
        }
        $currentRouteName = Route::currentRouteName();

        // TODO 可更换为menu数据

        foreach ($permissions as &$top)
        {

            if( !empty($top['child']) )
            {
                foreach ( $top['child'] as $key => &$sub )
                {
                    // users.edit users.index users.create
                   if( starts_with($sub['uri'],explode('.',$currentRouteName)[0]) )
                   {

                       $sub['active'] = 'active';

                       $top['active'] = 'active';
                   }

                    if ( !ends_with($sub['uri'],'index') )
                    {
                        unset($top['child'][$key]);

                    }
                }
            }
        }
        $request->attributes->set('menus',$permissions);

        return $next($request);
    }
}