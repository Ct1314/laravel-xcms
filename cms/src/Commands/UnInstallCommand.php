<?php

namespace XCms\Commands;


/*
* 
* name UnInstallCommand.php
* author Yuanchang
* date 2017/05/08
*/

use Illuminate\Console\Command;
use Admin\Models\Auth\AdminUser;
use Illuminate\Support\Facades\Cache;

class UninstallCommand extends Command
{
    protected $name = 'xcms:uninstall';

    protected $description = 'uninstall xcms package';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (!$this->confirm('Are you sure to uninstall xcms?')) {
            return;
        }

        $this->remove();

        $this->clear();

        $this->line('<info>Uninstalling xadmin success!</info>');
    }

    public function remove()
    {
        $this->laravel['files']->deleteDirectory(public_path('packages/admin'));

        $this->laravel['files']->deleteDirectory(public_path('packages/xcms'));

        $this->laravel['files']->delete(config_path('admin.php'));

        $this->laravel['files']->delete(config_path('xcms.php'));

        $this->laravel['files']->delete(config_path('fileupload.php'));

        $this->laravel['files']->delete(base_path('database/migrations/2017_04_26_154241_create_table_admin_tables.php'));

        $this->laravel['files']->delete(base_path('database/2017_04_25_123000_create_table_xcms.php'));

        $this->laravel['files']->delete(base_path('database/seeds/AdminSeeder.php'));
    }

    public function clear()
    {
        collect(AdminUser::all())->each(function($user){

           Cache::forget($user->id.'permissions');

           Cache::forget($user->id.'menus');
        });

        Cache::forget('permissions');
    }
}