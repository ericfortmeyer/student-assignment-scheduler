<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use StudentAssignmentScheduler\Classes\ListOfContacts;

use function StudentAssignmentScheduler\Functions\Encryption\box;

function deleteMode(ListOfContacts $contacts, string $path_to_contacts, string $key)
{
    listContacts($contacts);

    $index = (int) readline(selectPrompt("delete"));

    try {
        $selected = $contacts->get($index);

        $contacts->remove($selected);

        box(
            $contacts,
            $path_to_contacts,
            $key
        );

        print "${selected} has been deleted." . PHP_EOL;
    } catch (\OutOfRangeException $e) {
        print "Oops! It looks like ${index} is not on the list." . PHP_EOL;
        deleteMode($contacts, $path_to_contacts, $key);
    }
}
