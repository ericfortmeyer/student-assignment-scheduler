<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use StudentAssignmentScheduler\{
    SpecialEventHistory,
    Date,
    MonthOfAssignments,
    WeekOfAssignments
};

function scheduleWithoutSpecialEvents(
    SpecialEventHistory $SpecialEvents,
    MonthOfAssignments $schedule
): MonthOfAssignments {
    return $schedule->filter(
        function (Date $dateOfWeek, WeekOfAssignments $week) use ($SpecialEvents): bool {

            // we have to clone here since we will need to traverse
            // the stack to check each date in the schedule
            $CopyOfSpecialEvents = clone $SpecialEvents;

            while ($CopyOfSpecialEvents->hasFutureEvents()) {
                $SpecialEvent = $CopyOfSpecialEvents->latest();

                if ($dateOfWeek == $SpecialEvent->date()) {
                    // remove the date from the schedule
                    return false;
                }
            }
            return true;
        }
    );
}
