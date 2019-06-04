<?php

namespace StudentAssignmentScheduler\CLI\Commands\Resend;

use function StudentAssignmentScheduler\CLI\{
    displayList,
    red
};
use function StudentAssignmentScheduler\Querying\Functions\weeksOfAssignmentsInCurrentYear;

function userSelectsMonth(): string
{
    $availableMonths = monthsFromAssignments(
        weeksOfAssignmentsInCurrentYear()
    );
    $availableMonths->isEmpty() && exit(
        "It looks like there are no months of assignments to send.  Good bye."
    );
    displayList($availableMonths);
    $index = readline(
        "Please enter the number to the left of the available month of assignments: "
    );

    try {
        return $availableMonths->get($index);
    } catch (\OutOfRangeException $e) {
        print red("Sorry, ${index} is an invalid option.  Please try again") . PHP_EOL . PHP_EOL;
        return userSelectsMonth();
    }
}
