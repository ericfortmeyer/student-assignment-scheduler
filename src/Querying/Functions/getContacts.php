<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Querying\Functions;

use StudentAssignmentScheduler\ListOfContacts;
use function StudentAssignmentScheduler\Encryption\Functions\{
    masterKey,
    secretKey,
    unbox
};

function getContacts(
    string $path_to_contacts,
    string $path_to_master_key,
    string $path_to_stack_of_keys
): ListOfContacts {
    $master_key = masterKey($path_to_master_key);
    $secret_Key = secretKey($path_to_stack_of_keys, $master_key);

    return unbox($path_to_contacts, $secret_Key);
}
