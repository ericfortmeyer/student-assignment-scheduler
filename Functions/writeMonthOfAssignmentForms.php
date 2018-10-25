<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\AssignmentFormWriterInterface;

function writeMonthOfAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    string $month,
    string $path_to_json_assignments_files
): void {
    array_map(
        function (array $week_of_assignments) use ($AssignmentFormWriter) {
            writeAssignmentFormsFromArrayOfAssignments(
                $AssignmentFormWriter,
                $week_of_assignments
            );
        },
        monthOfAssignments($month)($path_to_json_assignments_files)
    );
}
