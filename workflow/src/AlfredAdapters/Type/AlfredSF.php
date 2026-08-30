<?php

declare(strict_types=1);

namespace Workflow\AlfredAdapters\Type;

/**
 * Top-level response returned by an Alfred Script Filter.
 *
 * @see https://www.alfredapp.com/help/workflows/inputs/script-filter/json/
 */
class AlfredSF extends AlfredSFBase
{
    /**
     * @param list<AlfredSFItem>        $items
     * @param null|array<string, mixed> $variables
     */
    public function __construct(
        public array $items,
        public ?array $variables = null,
        public ?string $rerun = null,
        public ?AlfredSFCache $cache = null,
        public ?bool $skipknowledge = null,
    ) {}
}
