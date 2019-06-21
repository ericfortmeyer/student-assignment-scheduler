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

function add(
    SpecialEventHistory $SpecialEventHistory,
    iterable $specialEvents
): SpecialEventHistory {
    $actionPastTense = "added";
    $EventType = userSelectsEventTypeFromList($specialEvents);
    $Event = userSelectsDate($EventType);
    $ModifiedHistory = $SpecialEventHistory->with($Event);
    print success($actionPastTense, $Event);
    return $ModifiedHistory;
}
