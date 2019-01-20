<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use StudentAssignmentScheduler\Utils\AssignmentFormWriterInterface;
use function StudentAssignmentScheduler\Functions\writeMonthOfAssignmentForms;
use function StudentAssignmentScheduler\Functions\monthsFromScheduleFilenames;

use \Closure;
use \Ds\Set;
use \Ds\Vector;

/**
 * Create assignment forms
 *
 * The json files representing weeks of assignments are used
 * to generate pdf assignment forms
 *
 * @param AssignmentFormWriterInterface $AssignmentFormWriter
 * @param string $path_to_json_assignments_files
 * @param string $path_to_json_schedules
 * @param Closure $hasScheduleAlreadyBeenCompleted
 * @param int $year Required to avoid January being considered after December
 * @param bool $do_past_months
 *
 * @return Vector  Which months of assignment forms were created?
 */
function writeAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    string $path_to_json_assignments_files,
    string $path_to_json_schedules,
    Closure $hasScheduleAlreadyBeenCompleted,
    int $year,
    bool $do_past_months = false
): Vector {

    $writeForms = function (array $arr) use (
        $AssignmentFormWriter,
        $path_to_json_assignments_files,
        $hasScheduleAlreadyBeenCompleted
    ): ?string {

        $month = $arr["month"];

        if ($hasScheduleAlreadyBeenCompleted($month)) {
            return null;
        }

        $didDisplay = displayTableOfMonthOfAssignments(
            $month,
            $path_to_json_assignments_files
        );

        $reply = $didDisplay
            ? readline(prompt("Does the schedule look good"))
            : "";

        if (yes($reply)) {
            writeMonthOfAssignmentForms(
                $AssignmentFormWriter,
                $month,
                $path_to_json_assignments_files
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
