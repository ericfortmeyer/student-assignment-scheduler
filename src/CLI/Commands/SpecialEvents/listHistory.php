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

use StudentAssignmentScheduler\SpecialEventHistory;

function listHistory(SpecialEventHistory $SpecialEventHistory): void
{
    abortIfEmpty("list", $SpecialEventHistory->toArray());
    
    print PHP_EOL
        . PHP_EOL
        . "List of special events"
        . PHP_EOL
        . "______________________" . PHP_EOL . PHP_EOL;

    array_map(
        function ($value) {
            print $value;
        },
        $SpecialEventHistory->toArray()
    );

    print PHP_EOL;
}
