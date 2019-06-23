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
use function StudentAssignmentScheduler\CLI\editContact;

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
