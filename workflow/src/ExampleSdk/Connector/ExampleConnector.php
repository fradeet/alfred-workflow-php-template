<?php

declare(strict_types=1);

namespace Workflow\ExampleSdk\Connector;

use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\PsrCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Http\Connector;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

final class ExampleConnector extends Connector implements Cacheable
{
    use HasCaching;

    private readonly Driver $cacheDriver;

    public function __construct(?string $cacheDirectory = null)
    {
        $cache = new FilesystemAdapter(
            namespace: 'workflow.example_sdk',
            directory: $cacheDirectory,
        );

        $this->cacheDriver = new PsrCacheDriver(new Psr16Cache($cache));
    }

    public function resolveBaseUrl(): string
    {
        return 'https://jsonplaceholder.typicode.com';
    }

    public function resolveCacheDriver(): Driver
    {
        return $this->cacheDriver;
    }

    public function cacheExpiryInSeconds(): int
    {
        return 300;
    }
}
