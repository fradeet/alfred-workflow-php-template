<?php

declare(strict_types=1);

namespace Workflow\AlfredAdapters\Type;

/** Configuration for Alfred's automatic Script Filter result cache. */
class AlfredSFCache extends AlfredSFBase
{
    public function __construct(
        public int $seconds,
        public ?bool $loosereload = null,
    ) {}
}
