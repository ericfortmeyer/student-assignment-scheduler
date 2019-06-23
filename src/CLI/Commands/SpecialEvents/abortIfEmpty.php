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
