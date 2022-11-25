<?php

namespace Pderas\Templar\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

#[AsCommand(name: 'make:api-wrapper')]
class ApiWrapperMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:api-wrapper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new API wrapper JS file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ApiWrapper';

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("resources/js/api/" . Str::singular(strtolower($name)) . ".js");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('vendor/pderas/templar/src/stubs/api-wrapper.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        // Replace {{ class }} with uppercase first $class plural (i.e Members)
        $replaced_upper = str_replace(['{{ class }}'], $class, $stub);

        // Replace {{ class_lower }} with lowercase $class plural (i.e members)
        $replaced_lower = str_replace(['{{ class_lower }}'], strtolower($class), $replaced_upper);

        // Replace {{ class_lower_singular }} with lowercase $class singular (i.e member)
        $replaced_lower_singular = str_replace(['{{ class_lower_singular }}'], Str::singular(strtolower($class)), $replaced_lower);

        // Replace {{ class_upper_singular }} with uppercase first $class plural (i.e Member)
        return str_replace(['{{ class_upper_singular }}'], Str::singular(Str::ucfirst($class)), $replaced_lower_singular);
    }

}
