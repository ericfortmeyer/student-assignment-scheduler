<?php

namespace StudentAssignmentScheduler\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\SpecialEventHistory;
// use StudentAssignmentScheduler\SpecialEventHistory;

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
