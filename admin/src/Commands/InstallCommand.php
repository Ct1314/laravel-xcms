<?php

namespace Admin\Commands;

/*
* 
* name InstallCommand.php
* author Yuanchang
* date ${DATA}
*/
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $name = 'xadmin:install';

    protected $description = 'Install the xadmin package';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->publishResource();

        $this->initDatabase();

        $this->line('<info>installing xadmin success!</info>');

        $this->call('serve',['--port'=>'8888']);
    }

    public function publishResource()
    {
        $this->call('vendor:publish',['--tag'=>'yuanchang-admin']);
    }
    public function initDatabase()
    {
        $this->call('migrate');

        $this->call('db:seed',['--class'=>'AdminSeeder']);
    }
}