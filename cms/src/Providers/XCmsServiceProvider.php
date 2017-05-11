<?php

namespace XCms\Providers;

use Xcms;
use Flash\FlashServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Baum\Providers\BaumServiceProvider;
use Admin\Providers\AdminServiceProvider;
use Intervention\Image\ImageServiceProvider;

class XCmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViews();

        $this->publishResource();

        $this->commands([
            'XCms\Commands\InstallCommand',
            'XCms\Commands\UnInstallCommand',
        ]);
    }

    public function register()
    {
        $this->app->register(XCmsRouteServiceProvider::class);

        $this->app->register(XCmsEventServiceProvider::class);

        $this->app->register(AdminServiceProvider::class);
        
        $this->app->register(FlashServiceProvider::class);

        $this->app->register(BaumServiceProvider::class);

        $this->app->register(ImageServiceProvider::class);

        $alias = AliasLoader::getInstance();

        $alias->alias('XCms','XCms\Facades\XCmsFacade');

        $alias->alias('Flash','Flash\FlashFacade');
    }

    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Article/views','article');

        $this->loadViewsFrom(__DIR__ .'/../Block/views','block');

        $this->loadViewsFrom(__DIR__.'/../Setting/views','setting');

        $this->loadViewsFrom(__DIR__.'/../Page/views','page');

        $this->loadViewsFrom(__DIR__.'/../Link/views','link');
    }

    public function publishResource()
    {
        $this->publishes([
            __DIR__ . '/../../configs/xcms.php' => config_path('xcms.php')
        ],'xcms');

        $this->publishes([
            __DIR__ . '/../../../fileupload/configs/fileupload.php' => config_path('fileupload.php')
        ],'xcms');

        $this->publishes([
            __DIR__.'/../../assets/' => public_path('packages/xcms/')
        ],'xcms');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => base_path('database/migrations')
        ],'xcms');

        $this->publishes([
            __DIR__ . '/../../database/seeds' => base_path('database/seeds')
        ],'xcms');
    }

}