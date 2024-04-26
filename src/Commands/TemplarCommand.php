<?php

namespace Pderas\Templar\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

abstract class TemplarCommand extends GeneratorCommand
{
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
     * Get the stub filename for the generator.
     *
     * @return string
     */
    protected abstract function getStubFilename();

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

        $class_lower = Str::camel($class);

        $class_snake = Str::snake($class);

        $class_word = Str::of($class_snake)->singular()->replace('_', ' ');

        // Replace {{ class }} with uppercase first $class plural (i.e MemberStatuses)
        $replaced_upper = str_replace(['{{ class }}'], $class, $stub);

        // Replace {{ class_lower }} with lowercase $class plural (i.e memberStatuses)
        $replaced_lower = str_replace(['{{ class_lower }}'], $class_lower, $replaced_upper);

        // Replace {{ class_lower_singular }} with lowercase $class singular (i.e memberStatus)
        $replaced_lower_singular = str_replace(['{{ class_lower_singular }}'], Str::singular($class_lower), $replaced_lower);

        // Replace {{ class_word }} with lowercase $class spaced (i.e member status)
        $replaced_class_word = str_replace(['{{ class_word }}'], $class_word, $replaced_lower_singular);

        // Replace {{ class_title }} with lowercase $class spaced (i.e Member Status)
        $replaced_class_title = str_replace(['{{ class_title }}'], Str::of($class_word)->title(), $replaced_class_word);

        // Replace {{ class_snake_singular }} with lowercase $class snake singular (i.e member_status)
        $replaced_snake_singular = str_replace(['{{ class_snake_singular }}'], Str::singular($class_snake), $replaced_class_title);

        // Replace {{ class_kebab }} with lowercase $class kebab (i.e member-statuses)
        $replaced_kebab = str_replace(['{{ class_kebab }}'], Str::kebab($class), $replaced_snake_singular);

        // Replace {{ class_upper_singular }} with uppercase first $class plural (i.e MemberStatuses)
        return str_replace(['{{ class_upper_singular }}'], Str::singular(Str::ucfirst($class_lower)), $replaced_kebab);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $filename = $this->getStubFilename();

        // Custom stub
        $path = base_path('stubs/' . $filename);

        // Use default if custom stub doesn't exist
        if (!File::exists($path)) {
            $path = realpath(__DIR__ . '/../stubs/' . $filename);
        }

        return $path;
    }
}
