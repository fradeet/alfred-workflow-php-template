<?php

declare(strict_types=1);

namespace Workflow;

use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\PsrCacheDriver;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Workflow\ExampleSdk\Connector\ExampleConnector;
use Workflow\ExampleSdk\Dto\Todo;
use Workflow\ExampleSdk\Request\GetExampleTodoRequest;

final readonly class ExampleGetTodo
{
    public function __construct(
        private ExampleConnector $connector = new ExampleConnector(),
        private ?string $cacheDirectory = null,
    ) {}

    public function __invoke(int $id): Todo
    {
        $request = new GetExampleTodoRequest($id, $this->cacheDriver());
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    private function cacheDriver(): Driver
    {
        $cache = new FilesystemAdapter(
            namespace: 'workflow.example_sdk.todo',
            directory: $this->cacheDirectory,
        );

        return new PsrCacheDriver(new Psr16Cache($cache));
    }
}
