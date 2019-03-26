<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\AssignmentFormWriterInterface;

function writeMonthOfAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    array $array_of_month_of_assignments
): void {
    
    array_map(
        function (array $week_of_assignments) use ($AssignmentFormWriter) {
            writeAssignmentFormsFromArrayOfAssignments(
                $AssignmentFormWriter,
                $week_of_assignments
            );
        },
        $array_of_month_of_assignments
    );
}
