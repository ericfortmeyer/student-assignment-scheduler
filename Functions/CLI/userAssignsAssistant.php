<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use StudentAssignmentScheduler\Classes\{
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
