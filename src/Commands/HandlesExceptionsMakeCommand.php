<?php

namespace Pderas\Templar\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[AsCommand(name: 'make:handles-exceptions')]
class HandlesExceptionsMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:handles-exceptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates HandlesExceptions trait file';

    /**
     * The name of the file.
     *
     * @var string
     */
    protected $filename = 'HandlesExceptions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->getFilePath();
        if (File::exists($path)) {
            return;
        }

        File::makeDirectory(dirname($path), 0755, true, true);

        File::put($path, $this->getFileContents());

        $this->info("Trait {$this->filename} created successfully");

        return Command::SUCCESS;
    }

    /**
     * Get path to write this file
     *
     * @return string
     */
    protected function getFilePath()
    {
        $filename = $this->filename . '.php';
        return base_path('app/Traits/' . $filename);
    }

    /**
     * Get file contents to use
     *
     * @return string|false
     */
    protected function getFileContents()
    {
        $contents = base_path('vendor/pderas/templar/src/stubs/handles-exceptions.stub');
        return file_get_contents($contents);
    }
}
