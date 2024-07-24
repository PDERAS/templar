<?php

namespace Pderas\Templar\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

#[AsCommand(name: 'templar:publish-stubs')]
class PublishStubsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templar:publish-stubs {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all stubs that are available for customization';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!is_dir($stubsPath = base_path('stubs'))) {
            (new Filesystem())->makeDirectory($stubsPath);
        }

        foreach ($this->getStubFilenames() as $file) {
            $from = realpath(__DIR__ . '/../stubs/' . $file);
            $to = $stubsPath . '/' . $file;

            if (!file_exists($to) || $this->option('force')) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        $this->info('Stubs published successfully.');
    }

    /**
     * Get all customizable stub file names
     *
     * @return array
     */
    protected function getStubFilenames()
    {
        return [
            'api-controller.stub',
            'service.stub',
            'vue-create-edit-modal.stub',
            'vue-listing-page.stub',
            'vuex-module-loader.stub',
            'vuex-store.stub',
            'web-controller.stub',
        ];
    }
}
