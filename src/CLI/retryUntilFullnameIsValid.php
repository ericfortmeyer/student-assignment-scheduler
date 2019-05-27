<?php

namespace StudentAssignmentScheduler\CLI;

use StudentAssignmentScheduler\{
    Fullname,
    ListOfContacts,
    Actions\Success,
    Actions\Failure,
    Utils\Selector
};
use function StudentAssignmentScheduler\InputValidation\Functions\fullnameIsValid;

function retryUntilFullnameIsValid(Fullname $fullname, ListOfContacts $ListOfContacts): string
{
    return Selector::do(
        fullnameIsValid(
            $fullname,
            $ListOfContacts
        ),
        new Success(function () use ($fullname): string {
            return (string) $fullname;
        }),
        new Failure(function () use ($fullname, $ListOfContacts): string {
            return retryUntilFullnameIsValid(
                new Fullname(
                    readline(
                        "Unable to find " . red($fullname) . " in the list of contacts" . PHP_EOL
                            . "Please try again: "
                    )
                ),
                $ListOfContacts
            );
        })
    );
}
