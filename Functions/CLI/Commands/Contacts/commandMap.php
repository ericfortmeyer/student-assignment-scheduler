<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use function StudentAssignmentScheduler\Functions\CLI\addContacts;
use function StudentAssignmentScheduler\Functions\promptsForContacts;
use function StudentAssignmentScheduler\Functions\promptsForScheduleRecipients;


use \Ds\{
    Map,
    Set
};

function commandMap(): Map
{
    return new Map(
        [
            "list" => function (Set $contacts) {
                listContacts($contacts);
            },
            "edit" => function (Set $contacts, string $path_to_contacts) {
                editMode(
                    $contacts,
                    $path_to_contacts,
                    getPrompts($path_to_contacts)
                );
            },
            "remove" => function (Set $contacts, string $path_to_contacts) {
                deleteMode(
                    $contacts,
                    $path_to_contacts
                );
            },
            "add" => function (Set $contacts, string $path_to_contacts) {
                addContacts(
                    $path_to_contacts,
                    getPrompts($path_to_contacts)
                );
            }
            ]
        );
    }
    
function getPrompts(string $path_to_contacts): array
{
    return basename($path_to_contacts) === "schedule_recipients.php"
        ? promptsForScheduleRecipients()
        : promptsForContacts();
}
