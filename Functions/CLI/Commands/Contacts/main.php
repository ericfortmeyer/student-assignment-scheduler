<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use function StudentAssignmentScheduler\Functions\Encryption\unbox;

use StudentAssignmentScheduler\Classes\ListOfContacts;

function main(string $path_to_contacts, string $key, string $command)
{
    if (!file_exists($path_to_contacts)) {
        echo "It looks like the contacts haven't been setup." . PHP_EOL
            . "Please set them up by running the assign command." . PHP_EOL;
        return;
    }

    $contacts = unbox($path_to_contacts, $key);

    $orDefault = function (ListOfContacts $contacts, string $path_to_contacts) {
        listContacts($contacts);
    };

    $selectedCommand = commandMap($key)->get($command, $orDefault);

    $selectedCommand($contacts, $path_to_contacts);
}
