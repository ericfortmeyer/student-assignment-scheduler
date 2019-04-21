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
            while ($SpecialEvents->hasFutureEvents()) {
                $SpecialEvent = $SpecialEvents->history()->pop();

                if ($dateOfWeek == $SpecialEvent->date()) {
                    // remove it
                    return false;
                }
            }
            return true;
        }
    );
}
