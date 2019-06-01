<?php

namespace StudentAssignmentScheduler\CLI\Commands\Resend;

use function StudentAssignmentScheduler\CLI\{
    displayList,
    red
};
use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;

use \Ds\Vector;

function userSelectsMonth(string $assignment_form_destination): string
{
    /**
     * @var Vector $availableMonths
     */
    $availableMonths = (new Vector(filenamesInDirectory($assignment_form_destination)))
        ->filter(__NAMESPACE__ . "\\removeAssignmentCopies")
        ->map(__NAMESPACE__ . "\\firstTwoCharsOfFilename")
        ->reduce(__NAMESPACE__ . "\\monthsFromFilenames");
    
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
        return userSelectsMonth($assignment_form_destination);
    }
}
