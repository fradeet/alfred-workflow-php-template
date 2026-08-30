<?php

declare(strict_types=1);

namespace Workflow\AlfredAdapters\Type;

/** Icon displayed alongside a Script Filter result. */
class AlfredSFItemIcon extends AlfredSFBase
{
    public function __construct(
        public string $path,
        public ?string $type = null,
    ) {}
}
