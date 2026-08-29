<?php

declare(strict_types=1);

use Alfred\Workflow\Hello;

require __DIR__.'/vendor/autoload.php';

/**
 * Adapt a plain title to Alfred's Script Filter JSON format.
 */
function toAlfredScriptFilterJson(string $title): string
{
    return json_encode(
        ['items' => [['title' => $title]]],
        JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
    );
}

echo toAlfredScriptFilterJson((new Hello())());
