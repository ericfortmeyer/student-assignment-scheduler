<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Classes\{
    DayOfMonth,
    Month
};

function dayOfMonthFromAssignmentDate(string $assignment_date): DayOfMonth
{
    [$month, $day] = explode(" ", $assignment_date);
    return new DayOfMonth(new Month($month), $day);
}
