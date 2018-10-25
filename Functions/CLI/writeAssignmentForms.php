<?php

namespace TalkSlipSender\Functions\CLI;

use TalkSlipSender\AssignmentFormWriterInterface;
use function TalkSlipSender\Functions\sortMonths;
use function TalkSlipSender\Functions\writeMonthOfAssignmentForms;

function writeAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    string $path_to_json_assignments_files,
    string $path_to_json_schedules
) {
    array_map(
        function (string $schedule_file) use (
            $AssignmentFormWriter,
            $path_to_json_assignments_files
        ) {

            $month = str_replace(".json", "", $schedule_file);

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
        array_map(
            function (array $arr) {
                return "{$arr["month"]}.json";
            },
            sortMonths(
                array_map(
                    function (string $filename) {
                        /**
                         * Requires key "month" to simplify passing arguments into
                         * sortMonths function for other clients
                         */
                        $result["month"] = str_replace(".json", "", $filename);
                        return $result;
                    },
                    array_diff(
                        scandir($path_to_json_schedules),
                        [".", "..", ".DS_Store"]
                    )
                )
            )
        )
    );
}
