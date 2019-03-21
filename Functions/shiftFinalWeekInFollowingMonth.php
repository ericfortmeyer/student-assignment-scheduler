<?php

namespace StudentAssignmentScheduler\Functions;

use \Ds\Vector;

function shiftFinalWeekInFollowingMonth(array $files): array
{
    /**
     * Weeks of assignments are named after the month of the schedule they are in.
     * For example, January 3 2019 is in the schedule for the month of December.
     * The week of January 3 should be shifted to the last file of the array
     *
     * Evidence that the array needs to be shifted:
     * (1) the difference of the first two elements is less than 7
     * (2) the count is over 4
     */
    $dates = array_map(
        function (string $filename) {
            return (int) basename($filename, ".json");
        },
        $files
    );

    /**
     * This is necessary because index of the elements of the array
     * can not be determined
     */
    $first_week = current($dates);
    $second_week = next($dates);

    $firstAndSecondWeekAreLessThanAWeekApart = $second_week - $first_week < 7;
    $moreThan4weeksTotal = count($dates) > 4;
    
    $mustShift = $firstAndSecondWeekAreLessThanAWeekApart
        || $moreThan4weeksTotal;

    $vector = new Vector($files);

    
    if ($mustShift) {
        // just to be safe
        $copy = $vector->copy();
        // move the first element to the end of the array
        $week_in_following_month = $copy->shift();
        $copy->push($week_in_following_month);

        return $copy->toArray();
    } else {
        return $files;
    }
}
