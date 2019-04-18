<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\Classes\SpecialEventHistory;

function edit(SpecialEventHistory $SpecialEventHistory): SpecialEventHistory
{
    $action = "edit";
    $actionPastTense = "${action}ted";

    abortIfEmpty($action, $SpecialEventHistory->toArray());

    $OriginalEvent = userSelectsEventFromList($action, $SpecialEventHistory);
    $EventModified = userSelectsDate($OriginalEvent->type());
    
    $ModifiedHistory = $SpecialEventHistory->update($OriginalEvent, $EventModified);

    print success($actionPastTense, $EventModified, $OriginalEvent);

    return $ModifiedHistory;
}