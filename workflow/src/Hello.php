<?php

declare(strict_types=1);

namespace Alfred\Workflow;

final class Hello
{
    public function __invoke(): string
    {
        return 'Hello Alfred';
    }
}
