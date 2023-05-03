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
        $class_lower = Str::lower(Str::singular($class_singular));

        // Keep track of what was generateed
        $generated = [
            'vue-listing' => false,
            'vuex-store' => false,
            'vue-create-edit-modal' => false,
            'api-wrapper' => false,
            'web-controller' => false,
            'api-controller' => false,
            'service' => false,
            'vuex-module-loader' => false,
            'requests' => false,
            'web-php' => false,
            'api-php' => false
        ];

        if ($ignore_prompt || $this->confirm("Generate vue 'listing' Page?")) {
            // Make vue file for "Page Listing"
            $this->call("make:vue-listing", ['name' => $this->getNameInput()]);
            $generated['vue-listing'] = true;
        }

        if ($ignore_prompt || $this->confirm("Generate Vuex store?")) {
            // Make js file for "Vuex Store"
            $this->call("make:vuex-store", ['name' => $this->getNameInput()]);
            $generated['vuex-store'] = true;
        }

        if ($ignore_prompt || $this->confirm("Generate vue created/edit modal?")) {
            // Make vue file for Create/Edit "Modal"
            $this->call("make:vue-create-edit-modal", ['name' => $this->getNameInput()]);

            $generated['vue-create-edit-modal'] = true;
        }

        if ($ignore_prompt || $this->confirm("Generate Api Wrapper?")) {
            // Make js file for "API wrapper"
            $this->call("make:api-wrapper", ['name' => $this->getNameInput()]);
            $generated['api-wrapper'] = true;
        }

        if ($ignore_prompt || $this->confirm("Generate Web Controller?")) {
            // Make php file for Web Controller
            $this->call("make:web-controller", ['name' => $this->getNameInput()]);
            $generated['web-controller'] = true;
        }

        if ($ignore_prompt || $this->confirm("Generate Api Controller?")) {
            // Make php file for API Controller
            $this->call("make:api-controller", ['name' => $this->getNameInput()]);
            $generated['api-controller'] = true;

            // Create HandlesException trait
            $this->call("make:handles-exceptions");
        }

        if ($ignore_prompt || $this->confirm("Generate Service?")) {
            // Make php file for Service
            $this->call("make:service", ['name' => $this->getNameInput()]);
            $generated['service'] = true;
        }

        if ($ignore_prompt || $this->confirm("Generate Vuex Module Loader?")) {
            // Make PHP file for "vuex modular loader"
            $this->call("make:vuex-module-loader", ['name' => $this->getNameInput()]);
            $generated['vuex-module-loader'] = true;
        }


        if ($ignore_prompt || $this->confirm("Generate Search/Store/Update/Delete Requests?")) {
            // Generate requests
            $this->call("make:request", [
                'name' => $this->getNameInput() . '/Search' . Str::singular($this->getNameInput()) . 'Request'
            ]);
            $this->call("make:request", [
                'name' => $this->getNameInput() . '/Store' . Str::singular($this->getNameInput()) . 'Request'
            ]);
            $this->call("make:request", [
                'name' => $this->getNameInput() . '/Update' . Str::singular($this->getNameInput()) . 'Request'
            ]);
            $this->call("make:request", [
                'name' => $this->getNameInput() . '/Delete' . Str::singular($this->getNameInput()) . 'Request'
            ]);
            $generated['requests'] = true;
            $this->info("<bg=red>\nWARNING: Don't forget to set the request 'authorization' parameter to true\n</>");
        }

        if ($ignore_prompt || $this->confirm("Write endpoint route to web.php file?")) {
            // Write the import to web.php

            // String after other imports
            $search_string =
                "\n\n/*" .
                "\n|--------------------------------------------------------------------------";
            $web_string_controller_import =
                "\nuse App\\Http\\Controllers\\{$class_singular}Controller;";

            $replace_string = $web_string_controller_import . $search_string;
            $this->files->replaceInFile(
                $search_string,
                $replace_string,
                base_path('routes/web.php'),
            );

            // Write the web prefix
            $web_route_prefix =
            "\nRoute::middleware(['auth'])->group(function () {";

            $this->files->append(
                base_path('routes/web.php'),
                $web_route_prefix
            );

            // Write the GET route to web.php
            $web_string_get =
            "\n\tRoute::get('/$class_lower_plural', [{$class_singular}Controller::class, '{$class_lower_plural}Page'])->name('{$this->getNameInput()}/{$this->getNameInput()}Page');";

            $this->files->append(
                base_path('routes/web.php'),
                $web_string_get
            );

            // Write the route postfix
            $web_route_postfix =
                "\n});";

            $this->files->append(
                base_path('routes/web.php'),
                $web_route_postfix
            );

            $generated['web-php'] = true;
            $this->info("Wrote to web.php");
        }

        if ($ignore_prompt || $this->confirm("Write CRUD endpoint route to api.php file?")) {
            // Write the controller import to api.php
            $search_string =
                "\n\n/*" .
                "\n|--------------------------------------------------------------------------";
            $api_string_controller_import =
                "\nuse App\\Http\\Controllers\\Api\\{$class_singular}Controller;";

            $replace_string = $api_string_controller_import . $search_string;
            $this->files->replaceInFile(
                $search_string,
                $replace_string,
                base_path('routes/api.php'),
            );

            // Write the route prefix
            $api_route_prefix =
            "\nRoute::middleware('auth:sanctum')->prefix('v1')->middleware('role:super_admin')->group(function () {";

            $this->files->append(
                base_path('routes/api.php'),
                $api_route_prefix
            );

            // Write the RESOURCE route to api.php
            $api_string_resource =
            "\n\tRoute::apiResource('{$class_lower_plural}', {$class_singular}Controller::class)->except('show');";

            $this->files->append(
                base_path('routes/api.php'),
                $api_string_resource
            );

            // Write the route postfix
            $api_route_postfix =
                "\n});";

            $this->files->append(
                base_path('routes/api.php'),
                $api_route_postfix
            );

            $generated['api-php'] = true;

            $this->info("Wrote to api.php");
        }

        /**
         * Render out a nice table to see what was generated
         */
        $headers = ['Name', 'Was Generated'];
        $table = [];

        foreach ($generated as $name => $was_generated) {
            $table[] = [
                $name,
                $was_generated ? '✅' : '❌'
            ];
        }

        $this->table($headers, $table);

        return 0;
    }

    /**
     * Helper function to append a string to a file
     *
     * @param String $import_statement
     * @param String $path
     *
     * @return boolean successful write
     */
    protected function appendStringToFile(String $import_statement, String $path)
    {
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
