<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use \Ds\Set;

function main(string $path_to_contacts, string $command)
{
    $contacts = new Set(require $path_to_contacts);

    $orDefault = function (Set $contacts, string $path_to_contacts) {
        listContacts($contacts);
    };

    $selectedCommand = commandMap()->get($command, $orDefault);

    $selectedCommand($contacts, $path_to_contacts);
}
