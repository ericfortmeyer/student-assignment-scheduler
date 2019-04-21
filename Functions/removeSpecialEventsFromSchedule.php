<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Classes\{
    SpecialEventHistory,
    Date,
    MonthOfAssignments,
    WeekOfAssignments,
};

function removeSpecialEventsFromSchedule(
    SpecialEventHistory $SpecialEvents,
    MonthOfAssignments $schedule
): MonthOfAssignments {
    return $schedule->filter(
        function (Date $dateOfWeek, WeekOfAssignments $week) use ($SpecialEvents): bool {

            // we have to clone here since we will need to traverse
            // the stack to check each date in the schedule
            $CopyOfSpecialEvents = clone $SpecialEvents;

            while ($CopyOfSpecialEvents->hasFutureEvents()) {
                $SpecialEvent = $CopyOfSpecialEvents->history()->pop();

                if ($dateOfWeek == $SpecialEvent->date()) {
                    // remove it
                    return false;
                }
            }
            return true;
        }
    );
}
