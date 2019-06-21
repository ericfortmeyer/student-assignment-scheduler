<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
