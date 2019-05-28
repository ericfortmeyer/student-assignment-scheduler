<?php

namespace StudentAssignmentScheduler\CLI\Commands\Contacts;

use StudentAssignmentScheduler\ListOfContacts;

use function StudentAssignmentScheduler\Encryption\Functions\unbox;

function main(string $path_to_contacts, string $key, string $command)
{
    if (!file_exists($path_to_contacts)) {
        echo "It looks like the contacts haven't been setup." . PHP_EOL
            . "Please set them up by running the assign command." . PHP_EOL;
        return;
    }
    $decryptedContacts = unbox($path_to_contacts, $key);
    $orDefault = function (ListOfContacts $contacts, string $path_to_contacts) {
        listContacts($contacts);
    };
    $selectedCommand = commandMap($key)->get($command, $orDefault);
    $selectedCommand($decryptedContacts, $path_to_contacts);
}
