<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\Contacts;

use StudentAssignmentScheduler\ListOfContacts;
use function StudentAssignmentScheduler\Encryption\Functions\box;

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
