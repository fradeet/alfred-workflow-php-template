<?php

declare(strict_types=1);

namespace Workflow;

use Workflow\ExampleSdk\Connector\ExampleConnector;
use Workflow\ExampleSdk\Dto\Todo;
use Workflow\ExampleSdk\Request\GetExampleTodoRequest;

final readonly class GetTodo
{
    public function __construct(
        private ExampleConnector $connector = new ExampleConnector(),
    ) {}

    public function __invoke(int $id): Todo
    {
        $request = new GetExampleTodoRequest($id);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
