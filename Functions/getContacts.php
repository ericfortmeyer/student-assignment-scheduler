<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Classes\ListOfContacts;

function getContacts(
    string $path_to_contacts,
    string $path_to_master_key,
    string $path_to_stack_of_keys
): ListOfContacts {
    $master_key = Encryption\masterKey($path_to_master_key);
    $secret_Key = Encryption\secretKey($path_to_stack_of_keys, $master_key);

    return Encryption\unbox($path_to_contacts, $secret_Key);
}