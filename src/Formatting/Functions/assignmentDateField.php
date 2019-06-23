<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
