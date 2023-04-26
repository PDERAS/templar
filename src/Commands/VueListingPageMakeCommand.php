<?php

namespace Pderas\Templar\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Support\Str;

#[AsCommand(name: 'make:vue-listing')]
class VueListingPageMakeCommand extends TemplarCommand
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
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("resources/js/pages/$name/{$name}Page.vue");
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
}
