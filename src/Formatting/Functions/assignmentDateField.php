<?php

namespace StudentAssignmentScheduler\Formatting\Functions;

use StudentAssignmentScheduler\{
    DayOfMonth,
    Policies\RuleInterface
};

function assignmentDateField(
    DayOfMonth $day_of_month,
    RuleInterface $rule
): string {
    return "{$rule->result()->is()} ${day_of_month}";
}
