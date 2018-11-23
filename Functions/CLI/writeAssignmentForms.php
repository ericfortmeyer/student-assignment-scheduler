<?php

namespace TalkSlipSender\Functions\CLI;

use TalkSlipSender\Utils\AssignmentFormWriterInterface;
use function TalkSlipSender\Functions\writeMonthOfAssignmentForms;
use function TalkSlipSender\Functions\monthsFromScheduleFilenames;

/**
 * Create assignment forms
 *
 * The json files representing weeks of assignments are used
 * to generate pdf assignment forms
 *
 * @param AssignmentFormWriterInterface $AssignmentFormWriter
 * @param string $path_to_json_assignments_files
 * @param string $path_to_json_schedules
 * @param bool $do_past_months
 * @return array  Which months of assignment forms were created?
 */
function writeAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    string $path_to_json_assignments_files,
    string $path_to_json_schedules,
    bool $do_past_months = false
): array {

    return array_map(
        function (array $arr) use (
            $AssignmentFormWriter,
            $path_to_json_assignments_files
        ) {

            $month = $arr["month"];

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

                /**
                 * Use to determine which month(s) were scheduled
                 */
                return $month;
            }
        },
        monthsFromScheduleFilenames($path_to_json_schedules, $do_past_months)
    );
}
