<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
