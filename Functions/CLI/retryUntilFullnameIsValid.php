<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\{
    getContacts,
    InputValidation\fullnameIsValid
};

use StudentAssignmentScheduler\Utils\Selector;
use StudentAssignmentScheduler\Classes\{
    Fullname,
    ListOfContacts,
    Actions\Success,
    Actions\Failure
};

function retryUntilFullnameIsValid(Fullname $fullname): string
{
    return Selector::do(
        fullnameIsValid(
            $fullname,
            new ListOfContacts(getContacts())
        ),
        new Success(function () use ($fullname): string {
            return (string) $fullname;
        }),
        new Failure(function () use ($fullname): string {
            return retryUntilFullnameIsValid(
                new Fullname(
                    readline(
                        "Unable to find " . red($fullname) . " in the list of contacts" . PHP_EOL
                            . "Please try again: "
                    )
                )
            );
        })
    );
}