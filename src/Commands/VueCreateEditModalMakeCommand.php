<?php

namespace Pderas\Templar\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Support\Str;

#[AsCommand(name: 'make:vue-create-edit-modal')]
class VueCreateEditModalMakeCommand extends TemplarCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:vue-create-edit-modal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new vue Create Edit modal file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'VueEditCreateModal';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("resources/js/modals/modals/" . strtolower($name) . '/' . $name. "Modal.vue");
    }

    /**
     * Get the stub filename for the generator.
     *
     * @return string
     */
    protected function getStubFilename()
    {
        return 'vue-create-edit-modal.stub';
    }
}
