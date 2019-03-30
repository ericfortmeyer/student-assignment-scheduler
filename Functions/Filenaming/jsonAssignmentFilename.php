<?php

namespace StudentAssignmentScheduler\Functions\Filenaming;

use StudentAssignmentScheduler\Classes\Destination;
use StudentAssignmentScheduler\Classes\Month;
use StudentAssignmentScheduler\Classes\DayOfMonth;

use StudentAssignmentScheduler\Rules\RuleInterface;

/*
    This function receives as input:
    (1) destination of assignments
    (2) Two digit month of the assignments' schedule
    (3) The date of the month for the assignment
    (4) Policy for determing the actual month of a week
        since it may overlap two months.

    This function should output:
    directory + month + underscore
    + week's actual month + day of the month + file extension

    In the case of May 2, 2019 (which is included in April's schdule)
    we should get "04_0502.json"

    Naming the files containing the weeks of assignments in this way
    simplifies file storage, retrieving the files, and the application's
    use of the filename for information about the week of assignments.
*/
function jsonAssignmentFilename(
    Destination $destination,
    Month $month,
    DayOfMonth $day_of_month,
    RuleInterface $rule
): string {
    $ext = ".json";
    return "${destination}/${month}_{$rule->result()->is()}${day_of_month}${ext}";
}
