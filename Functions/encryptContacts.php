<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Classes\ListOfContacts;

function encryptContacts(
    ListOfContacts $contacts_before_encryption,
    string $path_to_contacts,
    string $path_to_master_key,
    string $path_to_stack_of_keys
): void {
    Encryption\box(
        $contacts_before_encryption,
        $path_to_contacts,
        Encryption\secretKey(
            $path_to_stack_of_keys,
            Encryption\masterKey(
                $path_to_master_key
            )
        )
    );
}
