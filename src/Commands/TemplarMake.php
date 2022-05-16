<?php

namespace Pderas\Templar\Commands;

use Illuminate\Console\Command;

class TemplarMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templar:make {name}';

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
        // Make vue file for "Page Listing"
        $this->line("Generating Vue file for Page Lisitng...");
        $this->call("make:vue-listing", ['name' => $this->getNameInput()]);

        // Make vue file for Create/Edit "Modal"
        $this->line("Generating Vue file for Create/Edit Modal...");
        $this->call("make:vuex-store", ['name' => $this->getNameInput()]);

        // Make PHP file for "vuex modular loader"

        // Make js file for "Vuex Store"
        $this->line("Generating Vuex Store JS file...");
        $this->call("make:vue-create-edit-modal", ['name' => $this->getNameInput()]);

        // Make js file for "API wrapper"
        $this->line("Generating Api Wrapper JS file...");
        $this->call("make:api-wrapper", ['name' => $this->getNameInput()]);

        // Possibly generate for navConfig.js?

        // Make php file for Web Controller
        $this->line("Generating Web Controller PHP file...");
        $this->call("make:web-controller", ['name' => $this->getNameInput()]);

        // Make php file for API Controller

        // Figure out a way to edit exisitng routes (api.php and web.php) file and create

        return 0;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }
}
