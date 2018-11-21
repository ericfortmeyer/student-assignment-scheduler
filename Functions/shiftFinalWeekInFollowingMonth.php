<?php

namespace TalkSlipSender\Functions;

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
            return (int) str_replace(".json", "", $filename);
        },
        $files
    );

    /**
     * The index of the elements of the array can not be determined
     */
    $first_week = current($dates);
    $second_week = next($dates);

    if (
        //the assignment dates of the first and second week are less than 7 days
        ($second_week - $first_week < 7)
            // there are more than 4 weeks in the schedule
            && (count($dates) > 4)
    ) {
        $copy = $files;

        $week_in_following_month = array_shift($copy);

        $copy[] = $week_in_following_month;

        return $copy;
    } else {
        return $files;
    }
}
