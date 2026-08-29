<?php

declare(strict_types=1);

use Alfred\Workflow\Hello;

error_reporting(E_ALL);
ini_set('display_errors', 'stderr');

require __DIR__.'/vendor/autoload.php';

require __DIR__.'/AlfredScriptFilterType.php';

/**
 * Read a value from Alfred's script environment.
 */
function alfredEnvironmentVariable(string $name): ?string
{
    $value = getenv($name);

    return is_string($value) ? $value : null;
}

/**
 * Read the environment variables supplied by Alfred.
 *
 * @see https://www.alfredapp.com/help/workflows/script-environment-variables/
 *
 * @return array{
 *     alfred_preferences: null|string,
 *     alfred_preferences_localhash: null|string,
 *     alfred_theme: null|string,
 *     alfred_theme_background: null|string,
 *     alfred_theme_selection_background: null|string,
 *     alfred_theme_subtext: null|string,
 *     alfred_version: null|string,
 *     alfred_version_build: null|string,
 *     alfred_workflow_bundleid: null|string,
 *     alfred_workflow_cache: null|string,
 *     alfred_workflow_data: null|string,
 *     alfred_workflow_name: null|string,
 *     alfred_workflow_description: null|string,
 *     alfred_workflow_uid: null|string,
 *     alfred_workflow_version: null|string,
 *     alfred_debug: null|string,
 *     alfred_workflow_keyword: null|string,
 * }
 */
function alfredEnvironmentVariables(): array
{
    return [
        'alfred_preferences' => alfredEnvironmentVariable('alfred_preferences'),
        'alfred_preferences_localhash' => alfredEnvironmentVariable('alfred_preferences_localhash'),
        'alfred_theme' => alfredEnvironmentVariable('alfred_theme'),
        'alfred_theme_background' => alfredEnvironmentVariable('alfred_theme_background'),
        'alfred_theme_selection_background' => alfredEnvironmentVariable('alfred_theme_selection_background'),
        'alfred_theme_subtext' => alfredEnvironmentVariable('alfred_theme_subtext'),
        'alfred_version' => alfredEnvironmentVariable('alfred_version'),
        'alfred_version_build' => alfredEnvironmentVariable('alfred_version_build'),
        'alfred_workflow_bundleid' => alfredEnvironmentVariable('alfred_workflow_bundleid'),
        'alfred_workflow_cache' => alfredEnvironmentVariable('alfred_workflow_cache'),
        'alfred_workflow_data' => alfredEnvironmentVariable('alfred_workflow_data'),
        'alfred_workflow_name' => alfredEnvironmentVariable('alfred_workflow_name'),
        'alfred_workflow_description' => alfredEnvironmentVariable('alfred_workflow_description'),
        'alfred_workflow_uid' => alfredEnvironmentVariable('alfred_workflow_uid'),
        'alfred_workflow_version' => alfredEnvironmentVariable('alfred_workflow_version'),
        'alfred_debug' => alfredEnvironmentVariable('alfred_debug'),
        'alfred_workflow_keyword' => alfredEnvironmentVariable('alfred_workflow_keyword'),
    ];
}

/**
 * Dispatch a CLI task to the corresponding core class.
 *
 * @param list<string> $arguments
 */
function dispatchTask(string $task, array $arguments): string
{
    return match ($task) {
        'hello' => (new Hello())(...$arguments),
        default => throw new InvalidArgumentException(sprintf('Unknown task: %s', $task)),
    };
}

/**
 * Encode an Alfred Script Filter response as JSON.
 */
function toAlfredScriptFilterJson(AlfredSF $scriptFilter): string
{
    return json_encode(
        $scriptFilter,
        JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
    );
}

/**
 * Run the adapter with positional CLI arguments.
 *
 * @param list<string> $arguments
 */
function run(array $arguments): void
{
    $task = array_shift($arguments);

    if (null === $task) {
        throw new InvalidArgumentException('Usage: php AlfredAdapter.php <task> [argument ...]');
    }

    echo toAlfredScriptFilterJson(
        new AlfredSF(
            items: [
                new AlfredSFItem(title: dispatchTask($task, $arguments)),
            ],
        ),
    );
}

/**
 * Read and validate positional arguments supplied by the CLI runtime.
 *
 * @return list<string>
 */
function cliArguments(): array
{
    $arguments = $_SERVER['argv'] ?? null;

    if (!is_array($arguments)) {
        throw new RuntimeException('AlfredAdapter.php must be run from the command line.');
    }

    $cliArguments = [];

    foreach (array_slice($arguments, 1) as $argument) {
        if (!is_string($argument)) {
            throw new RuntimeException('CLI arguments must be strings.');
        }

        $cliArguments[] = $argument;
    }

    return $cliArguments;
}

try {
    run(cliArguments());
} catch (Throwable $exception) {
    echo toAlfredScriptFilterJson(RETURN_ERROR_ALFRED);

    exit(1);
}
