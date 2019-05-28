<?php

namespace StudentAssignmentScheduler\CLI;

use StudentAssignmentScheduler\{
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
