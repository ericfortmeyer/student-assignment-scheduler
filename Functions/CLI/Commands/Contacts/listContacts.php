<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use StudentAssignmentScheduler\Classes\{
    ListOfContacts,
    Contact
};

use function StudentAssignmentScheduler\Functions\CLI\displayList;

function listContacts(ListOfContacts $contacts)
{
    displayList(
        $contacts
            ->map(
                function (Contact $contact): string {
                    return (string) $contact;
                }
            )
            ->toArray()
    );
}
