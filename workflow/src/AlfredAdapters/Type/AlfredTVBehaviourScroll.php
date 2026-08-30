<?php

declare(strict_types=1);

namespace Workflow\AlfredAdapters\Type;

/** Where the Text View scrolls after receiving a response. */
enum AlfredTVBehaviourScroll: string
{
    case Auto = 'auto';
    case Start = 'start';
    case End = 'end';
}
