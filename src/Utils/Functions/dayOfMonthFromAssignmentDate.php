<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\Utils\Functions;

use StudentAssignmentScheduler\{
    DayOfMonth,
    Month
};

function dayOfMonthFromAssignmentDate(string $assignment_date): DayOfMonth
{
    [$month, $day] = explode(" ", $assignment_date);
    return new DayOfMonth(new Month($month), $day);
}
