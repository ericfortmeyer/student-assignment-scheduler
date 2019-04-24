<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\AssignmentFormWriterInterface;
use StudentAssignmentScheduler\Classes\ListOfContacts;

function writeMonthOfAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    ListOfContacts $ListOfContacts,
    array $array_of_month_of_assignments
): void {
    
    array_map(
        function (array $week_of_assignments) use ($AssignmentFormWriter, $ListOfContacts) {
            writeAssignmentFormsFromArrayOfAssignments(
                $AssignmentFormWriter,
                $ListOfContacts,
                $week_of_assignments
            );
        },
        $array_of_month_of_assignments
    );
}
