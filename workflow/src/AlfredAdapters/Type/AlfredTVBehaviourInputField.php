<?php

declare(strict_types=1);

namespace Workflow\AlfredAdapters\Type;

/** What happens to the Text View input field after actioning it. */
enum AlfredTVBehaviourInputField: string
{
    case Clear = 'clear';
    case Select = 'select';
}
