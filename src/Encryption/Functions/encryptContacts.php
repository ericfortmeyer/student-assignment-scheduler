<?php

namespace StudentAssignmentScheduler\Encryption\Functions;

use StudentAssignmentScheduler\ListOfContacts;

function encryptContacts(
    ListOfContacts $contacts_before_encryption,
    string $path_to_contacts,
    string $path_to_master_key,
    string $path_to_stack_of_keys
): void {
    box(
        $contacts_before_encryption,
        $path_to_contacts,
        secretKey(
            $path_to_stack_of_keys,
            masterKey(
                $path_to_master_key
            )
        )
    );
}
