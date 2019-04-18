<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\SpecialEvents;

function abortIfEmpty(string $action, array $list): void
{
    if (empty($list)) {
        exit(
            PHP_EOL . PHP_EOL
                . "There are no special events to ${action}." . PHP_EOL
                . "Good Bye." . PHP_EOL . PHP_EOL
        );
    }
}
