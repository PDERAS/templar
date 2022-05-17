<?php

namespace Pderas\Templar\Commands;

use Illuminate\Console\Command;
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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ignore_prompt = trim($this->option('all'));

        if ($ignore_prompt || $this->confirm("Generate vue 'listing' Page?")) {
            // Make vue file for "Page Listing"
            $this->line("Generating Vue file for Page Lisitng...");
            $this->call("make:vue-listing", ['name' => $this->getNameInput()]);
        }


        if ($ignore_prompt || $this->confirm("Generate vue created/edit modal?")) {
            // Make vue file for Create/Edit "Modal"
            $this->line("Generating Vue file for Create/Edit Modal...");
            $this->call("make:vuex-store", ['name' => $this->getNameInput()]);
        }

        // Make PHP file for "vuex modular loader"

        if ($ignore_prompt || $this->confirm("Generate Vuex store?")) {
            // Make js file for "Vuex Store"
            $this->line("Generating Vuex Store JS file...");
            $this->call("make:vue-create-edit-modal", ['name' => $this->getNameInput()]);
        }

        // Make js file for "API wrapper"
        if ($ignore_prompt || $this->confirm("Generate Api Wrapper?")) {
            $this->line("Generating Api Wrapper JS file...");
            $this->call("make:api-wrapper", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate Web Controller?")) {
            // Make php file for Web Controller
            $this->line("Generating Web Controller PHP file...");
            $this->call("make:web-controller", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate Api Controller?")) {
            // Make php file for API Controller
            $this->line("Generating API Controller PHP file...");
            $this->call("make:api-controller", ['name' => $this->getNameInput()]);
        }

        if ($ignore_prompt || $this->confirm("Generate Store/Update Requests?")) {
            // Generate requests
            $this->line("Generating API Requests ...");
            $this->call("make:request", [
                'name' => $this->getNameInput() . '/Store' . Str::singular($this->getNameInput()) . 'Request'
            ]);
            $this->call("make:request", [
                'name' => $this->getNameInput() . '/Update' . Str::singular($this->getNameInput()) . 'Request'
            ]);
        }

        if ($ignore_prompt || $this->confirm("Write endpoint route to web.php file?")) {
            $this->line("Wrote to web.php");
            // TODO
        }

        if ($ignore_prompt || $this->confirm("Write endpoint route to api.php file?")) {
            $this->line("Wrote to api.php");
            // TODO
        }

        return 0;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        // Trims, capitalizes and "plurals" a name
        return trim(
            Str::plural(
                ucfirst(
                    $this->argument('name')
                )
            )
        );
    }
}
