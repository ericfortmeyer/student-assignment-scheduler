<?php

namespace StudentAssignmentScheduler\CLI;

use StudentAssignmentScheduler\{
    ListOfContacts,
    DocumentProduction\AssignmentFormWriterInterface
};
use \Ds\{
    Set,
    Vector
};
use function StudentAssignmentScheduler\DocumentProduction\Functions\writeMonthOfAssignmentForms;
use function StudentAssignmentScheduler\Utils\Functions\monthsFromScheduleFilenames;
use function StudentAssignmentScheduler\Querying\Functions\monthOfAssignments;

/**
 * Create assignment forms
 *
 * The json files representing weeks of assignments are used
 * to generate pdf assignment forms
 *
 * @param AssignmentFormWriterInterface $AssignmentFormWriter
 * @param string $path_to_json_assignments_files
 * @param string $path_to_json_schedules
 * @param \Closure $hasScheduleAlreadyBeenCompleted
 * @param int $year Required to avoid January being considered after December
 * @param bool $do_past_months
 *
 * @return Vector  Which months of assignment forms were created?
 */
function writeAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    ListOfContacts $ListOfContacts,
    string $path_to_json_assignments_files,
    string $path_to_json_schedules,
    \Closure $hasScheduleAlreadyBeenCompleted,
    int $year,
    bool $do_past_months = false
): Vector {

    $writeForms = function (array $arr) use (
        $AssignmentFormWriter,
        $ListOfContacts,
        $path_to_json_assignments_files,
        $hasScheduleAlreadyBeenCompleted
    ): ?string {

        $month = $arr["month"];

        if ($hasScheduleAlreadyBeenCompleted($month)) {
            return null;
        }

        $partial = monthOfAssignments($month);
        $array_of_month_of_assignments = $partial($path_to_json_assignments_files);

        $didDisplay = displayTableOfMonthOfAssignments($array_of_month_of_assignments);

        $reply = $didDisplay
            ? readline(prompt("Does the schedule look good"))
            : "";

        if (yes($reply)) {
            writeMonthOfAssignmentForms(
                $AssignmentFormWriter,
                $ListOfContacts,
                $array_of_month_of_assignments
            );

            print green("Assignment forms for ${month} were created.\r\n");

             // Use to determine which month(s) were scheduled
            return $month;
        } else {
            return null;
        }
    };

    // first we use a vector for to map function
    $MonthsOfWrittenAssignmentForms = new Vector(
        monthsFromScheduleFilenames($path_to_json_schedules, $year, $do_past_months)
    );

    // then we use set to make values distinct and to remove null
    $Set = new Set($MonthsOfWrittenAssignmentForms->map($writeForms));
    $Set->remove(null);

    // finally we return a vector for mapping functions later in the program
    return new Vector($Set);
}
