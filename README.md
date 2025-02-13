# ⚡ Templar ⚡

A templating engine designed to generate supporting boilerplate using the Fabled pattern.

This can generate the following boilerplate:

- Vue listing page (with built-in paginated table and searching)
- Vue modal for creating and editing
- Vuex Store file
- Vuex Module Loader file
- API Controller with stubbed functions
- Service class with CRUD logic
- Web Controller for viewing the listing page
- Modify `web.php`
- Modify `api.php`

All of these files will be ready to use out of the box. You only need to create the relevant migration and fill out the Create/Update/Delete functions.

## Usage

When you run the command, the package will prompt for each file generation. Optionally, if you pass the `--all` parameter, it will generate all files without prompting.

```sh
php artisan templar:make {name} {--all}
```

### Example

First, generate the model and migration (optional):

```sh
php artisan make:model Member --migration
```

To generate boilerplate for a `Member`:

```sh
php artisan templar:make Members
```

To generate without prompts:

```sh
php artisan templar:make Members --all
```

You may pass a lowercase and non-plural `name` if you prefer. The command will automatically handle capitalization and pluralization using Laravel's built-in `Str::plural` helper function.

For example:

```sh
php artisan templar:make city --all
```

This will generate the correct `Cities` and `City` equivalents.

## Customizing

The stub files can be published for customization:

```sh
php artisan templar:publish-stubs
```

## ⚠️ Warning ⚠️

The command does not generate the backing Model or Migration.
