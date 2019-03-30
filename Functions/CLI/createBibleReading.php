<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function createBibleReading(string $date): array
{
    $assignment = "Bible Reading";
    echo heading($assignment);
    return createAssignment(
        $date,
        $assignment,
        readline("Enter student's name: ")
    );
}
