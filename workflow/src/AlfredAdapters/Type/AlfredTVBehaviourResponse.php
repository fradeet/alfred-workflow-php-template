<?php

declare(strict_types=1);

namespace Workflow\AlfredAdapters\Type;

/** How new response text updates the existing Text View content. */
enum AlfredTVBehaviourResponse: string
{
    case Replace = 'replace';
    case Append = 'append';
    case Prepend = 'prepend';
    case ReplaceLast = 'replacelast';
}
