<?php

namespace StudentAssignmentScheduler\CLI\Commands\Amend;

use StudentAssignmentScheduler\{
    Month,
    Exception\InvalidDateTypeArgumentException
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
