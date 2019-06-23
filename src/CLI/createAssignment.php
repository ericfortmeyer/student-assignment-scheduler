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

function createAssignment(
    ListOfContacts $ListOfContacts,
    string $date,
    string $assignment,
    string $name,
    string $assistant = "",
    string $counsel_point = ""
): array {
    $data = [
        "date" => $date,
        "assignment" => $assignment,
        "name" => $name,
        "counsel_point" => $counsel_point,
        "assistant" => $assistant
    ];
    $heading = snakeCaseToUCWords($assignment);

    do {
        echo "\r\n",
            "Assignment: " . white($heading) . "\r\n",
            "Name: " . white($data["name"]) . "\r\n",
            $data["assistant"] ? "Assistant: " . white($data["assistant"]) . "\r\n" : "",
            "Date: " . white($data["date"]) . "\r\n";

        // Ask the user if it is correct
        $reply = readline(isItCorrectPrompt());

        if (yes($reply)) {
            return $data;
        } elseif (no($reply)) {
            return createAssignment(
                $ListOfContacts,
                $date,
                $assignment,
                retryUntilFullnameIsValid(
                    new Fullname(
                        readline("Enter student's name: ")
                    ),
                    $ListOfContacts
                ),
                userAssignsAssistant($assignment, $ListOfContacts),
                $counsel_point
            );
        } else {
            echo "Please enter yes or no\r\n";
        }
    } while (notYesOrNo($reply));

    // To suppress phan error since the function must return an array
    return [];
}
