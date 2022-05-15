<?php

namespace Pderas\Templar;


use Illuminate\Support\ServiceProvider;
use Pderas\Templar\Commands\TemplarMake;
// Templating commands
use Pderas\Templar\Commands\VueMakeCommand;

class TemplarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TemplarMake::class,
                VueMakeCommand::class
            ]);
        }
    }
}
