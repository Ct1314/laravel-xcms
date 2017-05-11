<?php
namespace Flash;

use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    public function register()
    {
        
        $this->app->bind(
            'Flash\FlashSession',
            'Flash\LaravelSession'
        );

        $this->app->singleton('flash',function(){
            return $this->app->make(Flash::class);
        });
    }
    
    public function boot()
    {
        $this->publishes([
            __DIR__.'/view/toastr.css'=>public_path('/package/toastr/toastr.css'),
            __DIR__.'/view/toastr.min.css'=>public_path('/package/toastr/toastr.min.css'),
            __DIR__.'/view/toastr.js'=>public_path('/package/toastr/toastr.js'),
            __DIR__.'/view/toastr.min.js'=>public_path('/package/toastr/toastr.min.js'),
            __DIR__.'/view/flash-message.blade.php'=>resource_path('/vendor/yuanchang/laravel-message.blade.php'),
            __DIR__.'/flashmessage.php'=>config_path('flashmessage.php')
        ],'flash-message');
    }
}