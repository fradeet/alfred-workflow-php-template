# Project Organization Conventions

## Three-Layer Architecture

Keep the call direction strictly one-way:

```text
Alfred -> shell runner -> AlfredAdapter.php -> core class
```

### 1. Shell Runner Layer

- Put Alfred-facing shell scripts directly in `workflow/`.
- Provide one script for each business operation that Alfred can invoke. Name it `alfred_run_<operation>.sh`, for example `workflow/alfred_run_hello.sh`.
- Read Alfred user input and Alfred environment variables in this layer. Quote all values when forwarding them to PHP.
- Each runner must invoke `workflow/AlfredAdapter.php`; it must not load or call a core class directly.
- Keep runners thin. They may collect and forward Alfred runtime values, but must not contain business logic, build Alfred result data, or emit JSON themselves.
- Resolve files relative to the runner's own directory so execution does not depend on the current working directory.

### 2. Alfred Adapter Layer

- Use `workflow/AlfredAdapter.php` as the single gateway between every shell runner and the PHP core.
- Keep reusable Alfred-specific PHP functions in this file, including input adaptation, core function dispatch, Script Filter item assembly, JSON encoding, and writing results to standard output.
- Call core classes from this file and convert their plain PHP return values into the format Alfred requires.
- Do not put reusable business rules in the adapter.

### 3. Core Layer

- Keep all logic that has no direct dependency on Alfred in `workflow/src/`.
- Place each core class in the `Alfred\Workflow` namespace and follow PSR-4: the class name must match the filename.
- Core classes must not read Alfred environment variables or depend on Alfred user data implicitly. Pass required values to them explicitly.
- Core classes must return plain PHP values. They must not contain Alfred Script Filter structures, JSON fields, or console output logic.

## Loading and Running

- Composer maps `Alfred\Workflow\` to `workflow/src/` in `workflow/composer.json`.
- `workflow/AlfredAdapter.php` loads core classes through `workflow/vendor/autoload.php`; do not directly `require` individual core source files.
- After adding or renaming a core class, run `composer dump-autoload --working-dir=workflow` to update the autoloader.
- Run the Hello example through its shell runner with `workflow/alfred_run_hello.sh`.

## Alfred Script Filter Output

- Standard output must contain valid Alfred Script Filter JSON without logs or debugging text.
- Put each result in the top-level `items` array and use the `title` field for its title.
- Encode JSON with `JSON_THROW_ON_ERROR` to prevent encoding failures from being ignored silently.
- The current Hello example outputs `{"items":[{"title":"Hello Alfred"}]}`.

## Verification

Run at least the following commands after making changes:

```bash
bash -n workflow/*.sh
workflow/alfred_run_hello.sh
cd workflow && vendor/bin/phpstan analyse src AlfredAdapter.php --no-progress
cd workflow && vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=no
```
