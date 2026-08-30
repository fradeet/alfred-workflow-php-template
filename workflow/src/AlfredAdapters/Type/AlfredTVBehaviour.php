<?php

declare(strict_types=1);

namespace Workflow\AlfredAdapters\Type;

/** Controls how an Alfred Text View updates and handles its input field. */
class AlfredTVBehaviour extends AlfredTVBase
{
    public function __construct(
        public ?AlfredTVBehaviourResponse $response = null,
        public ?AlfredTVBehaviourScroll $scroll = null,
        public ?AlfredTVBehaviourInputField $inputfield = null,
    ) {}
}
