<?php

declare(strict_types=1);

namespace Workflow\ExampleSdk\Request;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Workflow\ExampleSdk\Dto\Todo;

final class GetTodoRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private readonly int $id) {}

    public function resolveEndpoint(): string
    {
        return '/todos/'.$this->id;
    }

    public function createDtoFromResponse(Response $response): Todo
    {
        $data = $response->json();

        if (
            !isset($data['userId'], $data['id'], $data['title'], $data['completed'])
            || !is_int($data['userId'])
            || !is_int($data['id'])
            || !is_string($data['title'])
            || !is_bool($data['completed'])
        ) {
            throw new \UnexpectedValueException('The todo response has an invalid structure.');
        }

        return new Todo(
            userId: $data['userId'],
            id: $data['id'],
            title: $data['title'],
            completed: $data['completed'],
        );
    }
}
