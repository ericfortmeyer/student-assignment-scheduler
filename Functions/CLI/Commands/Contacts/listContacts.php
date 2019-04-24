<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use StudentAssignmentScheduler\Classes\{
    ListOfContacts,
    Contact
};

use function StudentAssignmentScheduler\Functions\CLI\displayList;

function listContacts(ListOfContacts $contacts)
{
    $toString = function (Contact $contact): string {
        return (string) $contact;
    };
    
    displayList($contacts->map($toString)->toArray());
}
