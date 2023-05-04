<?php

namespace Pderas\Templar\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Support\Str;

#[AsCommand(name: 'make:vuex-module-loader')]
class VuexModuleLoaderMakeCommand extends TemplarCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:vuex-module-loader';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new vuex module loader file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'VuexModuleLoader';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("app/VuexLoaders/" . Str::singular($name). "ModuleLoader.php");
    }

    /**
     * Get the stub filename for the generator.
     *
     * @return string
     */
    protected function getStubFilename()
    {
        return 'vuex-module-loader.stub';
    }
}
