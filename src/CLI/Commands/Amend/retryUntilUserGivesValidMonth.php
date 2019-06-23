<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
