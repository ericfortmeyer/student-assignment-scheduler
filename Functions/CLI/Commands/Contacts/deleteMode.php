<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use function StudentAssignmentScheduler\Functions\generateContactsFile;

use \Ds\Set;

function deleteMode(Set $contacts, string $path_to_contacts)
{
    listContacts($contacts);

    $index = (int) readline(selectPrompt("delete"));

    try {
        $selected = $contacts->get($index);

        $contacts->remove($selected);

        generateContactsFile(
            $contacts->toArray(),
            $path_to_contacts
        );

        print "${selected} has been deleted." . PHP_EOL;
    } catch (\OutOfRangeException $e) {
        print "Oops! It looks like ${index} is not on the list." . PHP_EOL;
        deleteMode($contacts, $path_to_contacts);
    }
}
