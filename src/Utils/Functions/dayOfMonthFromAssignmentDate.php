<?php declare(strict_types=1);

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
