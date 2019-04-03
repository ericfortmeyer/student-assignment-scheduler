<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use StudentAssignmentScheduler\Classes\{
    Fullname,
    ListOfContacts
};

function createBibleReading(string $date, ListOfContacts $ListOfContacts): array
{
    $assignment = "Bible Reading";
    echo heading($assignment);
    return createAssignment(
        $ListOfContacts,
        $date,
        $assignment,
        retryUntilFullnameIsValid(
            new Fullname(readline("Enter student's name: ")),
            $ListOfContacts
        )
    );
}
