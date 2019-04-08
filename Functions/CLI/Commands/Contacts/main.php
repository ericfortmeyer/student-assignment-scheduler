<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use \Ds\Set;

function main(string $path_to_contacts, string $command)
{
    if (!file_exists($path_to_contacts)) {
        echo "It looks like the contacts haven't been setup." . PHP_EOL
            . "Please set them up by running the assign command." . PHP_EOL;
        return;
    }

    $contacts = new Set(require $path_to_contacts);

    $orDefault = function (Set $contacts, string $path_to_contacts) {
        listContacts($contacts);
    };

    $selectedCommand = commandMap()->get($command, $orDefault);

    $selectedCommand($contacts, $path_to_contacts);
}
