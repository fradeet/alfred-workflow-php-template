<?php

declare(strict_types=1);

namespace Workflow\ExampleSdk\Request;

use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Workflow\ExampleSdk\Dto\Todo;

final class GetExampleTodoRequest extends Request implements Cacheable
{
    use HasCaching;

    protected Method $method = Method::GET;

    public function __construct(
        private readonly int $id,
        private readonly Driver $cacheDriver,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/todos/'.$this->id;
    }

    public function resolveCacheDriver(): Driver
    {
        return $this->cacheDriver;
    }

    public function cacheExpiryInSeconds(): int
    {
        return 300;
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
