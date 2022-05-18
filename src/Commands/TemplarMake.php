<?php

namespace Pderas\Templar\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplarMake extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templar:make {name} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates template files using PDERAS patterns';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;


    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->intro();

        // Flags
        $ignore_prompt = trim($this->option('all'));

        // Extras
        $class_lower_plural = Str::lower($this->getNameInput());
        $class_singular = Str::singular($this->getNameInput());

        if ($ignore_prompt || $this->confirm("Generate vue 'listing' Page?")) {
            // Make vue file for "Page Listing"
            $this->call("make:vue-listing", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate vue created/edit modal?")) {
            // Make vue file for Create/Edit "Modal"
            $this->call("make:vuex-store", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate Vuex store?")) {
            // Make js file for "Vuex Store"
            $this->call("make:vue-create-edit-modal", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate Api Wrapper?")) {
            // Make js file for "API wrapper"
            $this->call("make:api-wrapper", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate Web Controller?")) {
            // Make php file for Web Controller
            $this->call("make:web-controller", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate Api Controller?")) {
            // Make php file for API Controller
            $this->call("make:api-controller", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate Vuex Module Loader?")) {
            // Make PHP file for "vuex modular loader"
            $this->call("make:vuex-module-loader", ['name' => $this->getNameInput()]);
        }


        if ($ignore_prompt || $this->confirm("Generate Store/Update Requests?")) {
            // Generate requests
            $this->call("make:request", [
                'name' => $this->getNameInput() . '/Store' . Str::singular($this->getNameInput()) . 'Request'
            ]);
            $this->call("make:request", [
                'name' => $this->getNameInput() . '/Update' . Str::singular($this->getNameInput()) . 'Request'
            ]);
        }

        if ($ignore_prompt || $this->confirm("Write endpoint route to web.php file?")) {
            // Write the import to web.php
            $web_string_controller_import =
                "\nuse App\\Http\\Controllers\\{$class_singular}Controller;";

            $this->files->append(
                base_path('routes/web.php'),
                $web_string_controller_import
            );

            // Write the route to web.php
            $web_string_get =
                "\nRoute::get('/$class_lower_plural', [{$class_singular}Controller::class, '{$class_lower_plural}Page'])->name('{$this->getNameInput()}/{$this->getNameInput()}Page');";

            $this->files->append(
                base_path('routes/web.php'),
                $web_string_get
            );
        }

        /* if ($ignore_prompt || $this->confirm("Write endpoint route to api.php file?")) {
            $this->line("Wrote to api.php");
            // TODO
        } */

        return 0;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        // Trims, capitalizes and "plurals" the name
        return trim(
            Str::plural(
                ucfirst(
                    $this->argument('name')
                )
            )
        );
    }

    /**
     * Displays ASCII intro
     *
     * @return void
     */
    private function intro()
    {
        $this->line('  ______                     __');
        $this->line(' /_  __/__  ____ ___  ____  / /___ ______');
        $this->line('  / / / _ \/ __ `__ \/ __ \/ / __ `/ ___/');
        $this->line(' / / /  __/ / / / / / /_/ / / /_/ / /  ');
        $this->line('/_/  \___/_/ /_/ /_/ .___/_/\__,_/_/');
        $this->line('                  /_/ ');
    }
}
