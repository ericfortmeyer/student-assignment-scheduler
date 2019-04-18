<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\SpecialEvents;

use StudentAssignmentScheduler\Classes\SpecialEventHistory;

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
