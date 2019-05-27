<?php

namespace StudentAssignmentScheduler\CLI\Commands\Contacts;

use function StudentAssignmentScheduler\Functions\CLI\editContact;

use StudentAssignmentScheduler\ListOfContacts;

function editMode(ListOfContacts $contacts, string $path_to_contacts, string $key, array $prompts): void
{
    listContacts($contacts);

    $index = (int) readline(selectPrompt("edit"));

    try {
        editContact($contacts, $index, $path_to_contacts, $key, $prompts);
    } catch (\OutOfRangeException $e) {
        print "Oops! It looks like ${index} is not on the list." . PHP_EOL;
        editMode($contacts, $path_to_contacts, $key, $prompts);
    }
}
