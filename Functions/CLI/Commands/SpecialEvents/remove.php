<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\Classes\SpecialEventHistory;

function remove(SpecialEventHistory $SpecialEventHistory): SpecialEventHistory
{
    $action = "remove";
    $actionPastTense = "${action}d";

    abortIfEmpty($action, $SpecialEventHistory->toArray());

    $Event = userSelectsEventFromList($action, $SpecialEventHistory);
    
    $ModifiedHistory = $SpecialEventHistory->remove($Event);

    print success($actionPastTense, $Event);

    return $ModifiedHistory;
}
