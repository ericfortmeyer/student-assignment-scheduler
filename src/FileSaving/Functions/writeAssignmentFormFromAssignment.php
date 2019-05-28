<?php

namespace StudentAssignmentScheduler\FileSaving\Functions;

use StudentAssignmentScheduler\FileSaving\AssignmentFormWriterInterface;

function writeAssignmentFormFromAssignment(
    AssignmentFormWriterInterface $Writer,
    string $assignment_number,
    array $assignment,
    string $filename_of_assignment_form
) {
    $Writer->create($assignment_number, $assignment, $filename_of_assignment_form);
}
