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

function edit(SpecialEventHistory $SpecialEventHistory): SpecialEventHistory
{
    $action = "edit";
    $actionPastTense = "${action}ed";
    abortIfEmpty($action, $SpecialEventHistory->toArray());
    $OriginalEvent = userSelectsEventFromList($action, $SpecialEventHistory);
    $EventModified = userSelectsDate($OriginalEvent->type());
    $ModifiedHistory = $SpecialEventHistory->update($OriginalEvent, $EventModified);
    print success($actionPastTense, $EventModified, $OriginalEvent);
    return $ModifiedHistory;
}
