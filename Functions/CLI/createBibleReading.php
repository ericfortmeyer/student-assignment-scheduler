<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use StudentAssignmentScheduler\Classes\Fullname;

function createBibleReading(string $date): array
{
    $assignment = "Bible Reading";
    echo heading($assignment);
    return createAssignment(
        $date,
        $assignment,
        retryUntilFullnameIsValid(new Fullname(readline("Enter student's name: ")))
    );
}
