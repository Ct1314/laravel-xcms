<?php

namespace XCms\Commands;
/*
* name InstallCommans.php
* user Yuanchang.xu
* date 2017/5/8
*/

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $name = 'xcms:install';

    protected $description = 'install the package';

    public function handle()
    {
        $this->publish();

        $this->migrate();

        $this->line('<info>installing xadmin success! allow http://127.0.0.1:8888</info>');

        $this->call('serve',['--port'=>'8000']);
    }

    public function publish()
    {
        $this->call('vendor:publish',['--tag'=>'yuanchang-admin']);
        $this->call('vendor:publish',['--tag'=>'xcms']);
    }

    public function migrate()
    {
        $this->call('migrate');

        $this->call('db:seed',['--class'=>'AdminSeeder']);
    }
}