<?php

declare(strict_types=1);

namespace Workflow\AlfredAdapters\Type;

/**
 * Top-level response used to populate an Alfred Text View.
 *
 * @see https://www.alfredapp.com/help/workflows/user-interface/text/json/
 */
class AlfredTV extends AlfredTVBase
{
    /** @param null|array<string, mixed> $variables */
    public function __construct(
        public string $response,
        public ?array $variables = null,
        public ?float $rerun = null,
        public ?string $footer = null,
        public ?bool $actionoutput = null,
        public ?AlfredTVBehaviour $behaviour = null,
    ) {}
}
