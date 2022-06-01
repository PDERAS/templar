# ⚡ Templar ⚡

A command for generating files related to the PDERAS pattern.

This command will generate the following:

- Vue listing page (with built-in paginated table + searching)
- Vue modal for creating and editing
- Vuex Store file
- Vuex Modular Loader file
- JS API wrapper file
- An API Controller with stubbed functions
- Web Controller for viewing the listing page
- Modify web.php
- Modify api.php

All of these files will be 'plugged-in' out of the box, ready to use. All you have to do is create the relevant migration and fill out the Create/Update/Delete functions.

## Usage
When you run the command, the package will prompt for each file generation. Optionally if you pass the `--all` param, it will generate all without the prompt.

`php artisan templar:make {name} {--all}`

### Example

First generate model and migration (optional)

`php artisan make:model Member --migration`

To generate boilerplate for a `Member`

`php artisan templar:make Members`

To generate without question prompt

`php artisan templar:make Members --all`

You may pass lower case and non-plural `name` if you desire. Note that the command will automatically handle captalization and plural of a word using laravels built in Str::plural helper function.

For example:

`php artisan templar:make city --all`

Will generate the correct Cities and City equivalent

## ⚠️ Warning ⚠️
The command does not generate the backing Model or Migration.
