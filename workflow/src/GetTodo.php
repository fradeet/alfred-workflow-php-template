<?php

declare(strict_types=1);

namespace Workflow;

use Workflow\ExampleSdk\Connector\ExampleConnector;
use Workflow\ExampleSdk\Dto\Todo;
use Workflow\ExampleSdk\Request\GetExampleTodoRequest;

final readonly class GetTodo
{
    private ExampleConnector $connector;

    public function __construct(
        ?ExampleConnector $connector = null,
        ?string $cacheDirectory = null,
    ) {
        $this->connector = $connector ?? new ExampleConnector($cacheDirectory);
    }

    public function __invoke(int $id): Todo
    {
        $request = new GetExampleTodoRequest($id);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
