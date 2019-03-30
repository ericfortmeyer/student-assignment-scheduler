<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Classes\DayOfMonth;
use StudentAssignmentScheduler\Rules\RuleInterface;

function assignmentDateField(
    DayOfMonth $day_of_month,
    RuleInterface $rule
): string {
    return "{$rule->result()->is()} ${day_of_month}";
}
