<?php

namespace Pderas\Templar\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

#[AsCommand(name: 'make:vue-listing')]
class VueListingPageMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:vue-listing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new vue listing file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Vue';

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

        return base_path("resources/js/pages/$name/{$name}ListingPage.vue");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('vendor/pderas/templar/src/stubs/vue-listing-page.stub');
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

        // Replace {{ class }} with $class
        $replaced_upper = str_replace(['{{ class }}'], $class, $stub);

        // Replace {{ class_lower }} with lowercase $class
        $replaced_lower = str_replace(['{{ class_lower }}'], strtolower($class), $replaced_upper);

        // Replace {{ class_lower_singluar }} with lowercase $class singular
        return str_replace(['{{ class_lower_singular }}'], Str::singular(strtolower($class)), $replaced_lower);
    }

}