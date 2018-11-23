<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\AssignmentFormWriterInterface;

function writeMonthOfAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    string $month,
    string $path_to_json_assignments_files
): void {
    
    $partial = monthOfAssignments($month);
    
    array_map(
        function (array $week_of_assignments) use ($AssignmentFormWriter) {
            writeAssignmentFormsFromArrayOfAssignments(
                $AssignmentFormWriter,
                $week_of_assignments
            );
        },
        $partial($path_to_json_assignments_files)
    );
}
