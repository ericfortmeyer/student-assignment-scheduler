<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use function StudentAssignmentScheduler\Functions\CLI\editContact;

use \Ds\Set;

function editMode(Set $contacts, string $path_to_contacts, array $prompts): void
{
    listContacts($contacts);

    $index = (int) readline(selectPrompt("edit"));

    try {
        $selected = $contacts->get($index);
        editContact($contacts, $index, $path_to_contacts, $prompts);
    } catch (\OutOfRangeException $e) {
        print "Oops! It looks like ${index} is not on the list." . PHP_EOL;
        editContact($contacts, $index, $path_to_contacts, $prompts);
    }
}
