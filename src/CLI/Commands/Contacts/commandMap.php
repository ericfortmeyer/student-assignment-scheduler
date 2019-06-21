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
use \Ds\Map;
use function StudentAssignmentScheduler\CLI\{
    addContacts,
    promptsForContacts,
    promptsForScheduleRecipients
};

function commandMap(string $key): Map
{
    return new Map(
        [
            "list" => function (ListOfContacts $contacts) {
                listContacts($contacts);
            },
            "edit" => function (ListOfContacts $contacts, string $path_to_contacts) use ($key) {
                editMode(
                    $contacts,
                    $path_to_contacts,
                    $key,
                    getPrompts($path_to_contacts)
                );
            },
            "remove" => function (ListOfContacts $contacts, string $path_to_contacts) use ($key) {
                deleteMode(
                    $contacts,
                    $path_to_contacts,
                    $key
                );
            },
            "add" => function (ListOfContacts $contacts, string $path_to_contacts) use ($key) {
                !file_exists(dirname($path_to_contacts)) && mkdir(dirname($path_to_contacts));
                addContacts(
                    $path_to_contacts,
                    $key,
                    getPrompts($path_to_contacts)
                );
            }
        ]
    );
}
    
function getPrompts(string $path_to_contacts): array
{
    return basename($path_to_contacts) === "schedule_recipients"
        ? promptsForScheduleRecipients()
        : promptsForContacts();
}
