# Templar

A command for generating several files related to the PDERAS pattern. This command will generate the following:

- Vue listing page (with built-in paginated table + searching)
- Vue modal for creating and editing *(TODO)*
- Vuex Store file
- Vuex Modular Loader file
- JS API wrapper file
- Model *(TODO)*
- An API Controller with stubbed functions *(TODO)*
- Web Controller for viewing the listing page
- Modify web.php and api.php *(TODO)*

All of these files will be 'plugged-in' out of the box, ready to use. All you have to do is create the relevant migration and fill out the Create/Update/Delete functions. *(TODO)*

## Usage
When you run the command, the package will prompt for each file generation. Optionally if you pass the `--all` param, it will generate all without the prompt. Finally, the `--force` flag will override any existing files. *(TODO)*

`php artisan templar:make {name}`

    Notice: the name parmater should be captalized and plural.

### Example
`php artisan templar:make Members`

## Options
- Force *(TODO)*
- All *(TODO)*
