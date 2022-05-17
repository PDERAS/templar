<?php

namespace Pderas\Templar;

use Illuminate\Support\ServiceProvider;
use Pderas\Templar\Commands\ApiControllerMakeCommand;
use Pderas\Templar\Commands\TemplarMake;
// Templating commands
use Pderas\Templar\Commands\VueListingPageMakeCommand;
use Pderas\Templar\Commands\VuexStoreMakeCommand;
use Pderas\Templar\Commands\ApiWrapperMakeCommand;
use Pderas\Templar\Commands\VueCreateEditModalMakeCommand;
use Pderas\Templar\Commands\WebControllerMakeCommand;

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
                VueListingPageMakeCommand::class,
                VuexStoreMakeCommand::class,
                ApiWrapperMakeCommand::class,
                VueCreateEditModalMakeCommand::class,
                WebControllerMakeCommand::class,
                ApiControllerMakeCommand::class
            ]);
        }
    }
}
