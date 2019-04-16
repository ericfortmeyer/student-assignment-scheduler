<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Classes\DayOfMonth;

function dayOfMonthFromAssignmentDate(string $assignment_date): DayOfMonth
{
    return new DayOfMonth(explode(" ", $assignment_date)[1]);
}
