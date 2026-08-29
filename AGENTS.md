# Project Organization Conventions

## Directories and Responsibilities

- Keep only core business logic in `workflow/src/`. It must not contain Alfred Script Filter data structures, JSON fields, or console output logic.
- Place each core class in the `Alfred\Workflow` namespace and follow PSR-4: the class name must match the filename.
- Use `workflow/AlfredAdapter.php` as the Alfred adapter and runtime entry point. Keep all Alfred-specific logic in this file, including Script Filter data assembly, JSON encoding, and writing results to standard output.
- Core classes must return plain PHP values that do not depend on the runtime environment. `AlfredAdapter.php` converts those values to the format Alfred requires.

## Loading and Running

- Composer maps `Alfred\Workflow\` to `workflow/src/` in `workflow/composer.json`.
- The runtime entry point loads core classes through `workflow/vendor/autoload.php`; do not directly `require` individual core source files.
- After adding or renaming a core class, run `composer dump-autoload --working-dir=workflow` to update the autoloader.
- Run the example with `php workflow/AlfredAdapter.php`.

## Alfred Script Filter Output

- Standard output must contain valid Alfred Script Filter JSON without logs or debugging text.
- Put each result in the top-level `items` array and use the `title` field for its title.
- Encode JSON with `JSON_THROW_ON_ERROR` to prevent encoding failures from being ignored silently.
- The current Hello example outputs `{"items":[{"title":"Hello Alfred"}]}`.

## Verification

Run at least the following commands after making changes:

```bash
php workflow/AlfredAdapter.php
cd workflow && vendor/bin/phpstan analyse src AlfredAdapter.php --no-progress
cd workflow && vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=no
```
