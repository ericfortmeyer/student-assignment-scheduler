<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use function StudentAssignmentScheduler\Functions\CLI\addContacts;
use function StudentAssignmentScheduler\Functions\promptsForContacts;
use function StudentAssignmentScheduler\Functions\promptsForScheduleRecipients;

use StudentAssignmentScheduler\Classes\ListOfContacts;
use \Ds\Map;

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
