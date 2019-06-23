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

function userAssignsAssistant(string $assignment, ListOfContacts $ListOfContacts): string
{
    return $assignment === "Talk" || $assignment === "Bible Reading"
        ? ""
        : retryUntilFullnameIsValid(
            new Fullname(readline("Enter assistant's name: ")),
            $ListOfContacts
        );
}
