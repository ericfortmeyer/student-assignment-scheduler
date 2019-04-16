<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Amend;

use StudentAssignmentScheduler\Classes\{
    Month,
    InvalidDateTypeArgumentException,
};

function retryUntilUserGivesValidMonth(string $month): Month
{
    try {
        $month = new Month($month);
    } catch (InvalidDateTypeArgumentException $e) {
        print $e->getMessage() . PHP_EOL;
        $month = retryUntilUserGivesValidMonth(
            promptUserForMonth()
        );
    }
    return $month;
}
