<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\Classes\SpecialEventHistory;

function add(
    SpecialEventHistory $SpecialEventHistory,
    iterable $specialEvents
): SpecialEventHistory {
    $actionPastTense = "added";

    $EventType = userSelectsEventTypeFromList($specialEvents);
    $Event = userSelectsDate($EventType);

    $ModifiedHistory = $SpecialEventHistory->add($Event);

    print success($actionPastTense, $Event);

    return $ModifiedHistory;
}
