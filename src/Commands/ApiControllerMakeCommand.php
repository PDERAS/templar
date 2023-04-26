<?php

namespace Pderas\Templar\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Support\Str;

#[AsCommand(name: 'make:api-controller')]
class ApiControllerMakeCommand extends TemplarCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:api-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new api controller file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ApiController';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("app/Http/Controllers/Api/" . Str::singular($name) . "Controller.php");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('vendor/pderas/templar/src/stubs/api-controller.stub');
    }
}
