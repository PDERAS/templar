<?php

namespace Pderas\Templar\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Support\Str;

#[AsCommand(name: 'make:vuex-store')]
class VuexStoreMakeCommand extends TemplarCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:vuex-store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new vuex store file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Vuex';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("resources/js/store/modules/" . Str::singular(strtolower($name)) . ".js");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('vendor/pderas/templar/src/stubs/vuex-store.stub');
    }
}
