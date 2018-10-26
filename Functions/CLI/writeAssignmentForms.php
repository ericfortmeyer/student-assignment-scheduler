<?php

namespace TalkSlipSender\Functions\CLI;

use TalkSlipSender\AssignmentFormWriterInterface;
use function TalkSlipSender\Functions\sortMonths;
use function TalkSlipSender\Functions\writeMonthOfAssignmentForms;
use function TalkSlipSender\Functions\monthsFromScheduleFilenames;

function writeAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    string $path_to_json_assignments_files,
    string $path_to_json_schedules
) {

    array_map(
        function (string $month) use (
            $AssignmentFormWriter,
            $path_to_json_assignments_files
        ) {

            if (empty($month)) {
                return;
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
            }
        },
        monthsFromScheduleFilenames($path_to_json_schedules)
    );
}
