# Templar

A command for generating several files related to the PDERAS pattern. This command will generate the following:

- Vue listing page (with a table searching)
- Vue modal for creating and editing
- Vuex Store file
- JS API wrapper file (TODO)
- Model (TODO)
- An API and Web Controller with stubbed functions (TODO)
- Modify web.php and api.php (TODO)

All of these files will be 'plugged-in' out of the box, ready to use. All you have to do is create the relevant migration and fill out the Create/Update/Delete functions. (TODO)

## Usage
When you run the command, the package will prompt for each file generation. Optionally if you pass the `--all` param, it will generate all without the prompt. Finally, the `--force` flag will override any existing files. (TODO)

`php artisan templar:make {name}`

    Notice: the name parmater should be captalized and plural.

### Example
`php artisan templar:make Members`

## Options
- Force (todo)
- All (todo)
