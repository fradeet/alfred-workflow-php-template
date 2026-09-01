#!/usr/bin/env php
<?php

declare(strict_types=1);

use Workflow\AlfredAdapters\Type\AlfredSF;
use Workflow\AlfredAdapters\Type\AlfredSFItem;
use Workflow\GetTodo;

use function Workflow\AlfredAdapters\Support\alfredEnvironmentVariable;
use function Workflow\AlfredAdapters\Support\run;

require dirname(__DIR__, 2).'/vendor/autoload.php';

run(
    static function (array $arguments): AlfredSF {
        if (1 !== count($arguments)) {
            throw new InvalidArgumentException('GetTodo expects exactly one todo ID.');
        }

        $id = filter_var(
            $arguments[0],
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]],
        );

        if (false === $id) {
            throw new InvalidArgumentException('The todo ID must be a positive integer.');
        }

        $todo = (new GetTodo(
            cacheDirectory: alfredEnvironmentVariable('alfred_workflow_cache'),
        ))($id);

        return new AlfredSF(
            items: [
                new AlfredSFItem(
                    title: $todo->title,
                    arg: (string) $todo->id,
                    subtitle: $todo->completed ? 'Completed' : 'Not completed',
                    uid: 'todo-'.$todo->id,
                ),
            ],
        );
    },
);
