<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\SpecialEvent;

use function StudentAssignmentScheduler\CLI\green;
use function StudentAssignmentScheduler\CLI\red;

/**
 * A message that the action was successful.
 *
 * @param string $action
 * @param SpecialEvent $event
 * @param SpecialEvent|null $original_event
 * @return string
 */
function success(string $action, SpecialEvent $event, ?SpecialEvent $original_event = null): string
{
    return PHP_EOL . PHP_EOL
        . "This event was ${action}: " . PHP_EOL . PHP_EOL
        . eventLines($event, $original_event);
}

/**
 * Information about the event that will be appended
 * to the message.
 *
 * @param SpecialEvent $event
 * @param SpecialEvent|null $original_event
 * @return string
 */
function eventLines(SpecialEvent $event, ?SpecialEvent $original_event): string
{
    return !empty($original_event)
        ? "Previous event..." . PHP_EOL .  red((string) $original_event) . PHP_EOL
            . "Is now..." . PHP_EOL . green((string) $event) . PHP_EOL . PHP_EOL
        : green((string) $event) . PHP_EOL . PHP_EOL;
}
