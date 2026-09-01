<?php

declare(strict_types=1);

namespace Workflow\ExampleSdk\Connector;

use Saloon\Http\Connector;

final class ExampleConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://jsonplaceholder.typicode.com';
    }
}
