<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\AssignmentFormWriterInterface;

function writeAssignmentFormFromAssignment(
    AssignmentFormWriterInterface $Writer,
    array $assignment
) {
    $Writer->create($assignment);
}
