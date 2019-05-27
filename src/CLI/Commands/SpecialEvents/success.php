<?php

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\SpecialEvent;

use function StudentAssignmentScheduler\Functions\CLI\{
    green,
    red
};

function success(string $action, SpecialEvent $event, ?SpecialEvent $original_event = null): string
{
    return PHP_EOL . PHP_EOL
        . "This event was ${action}: " . PHP_EOL . PHP_EOL
        . eventLines($event, $original_event);
}

function eventLines(SpecialEvent $event, ?SpecialEvent $original_event): string
{
    return !empty($original_event)
        ? "Previous event..." . PHP_EOL .  red($original_event) . PHP_EOL
            . "Is now..." . PHP_EOL . green($event) . PHP_EOL . PHP_EOL
        : green($event) . PHP_EOL . PHP_EOL;
}
