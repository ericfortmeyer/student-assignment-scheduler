<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Encryption\Functions;

use StudentAssignmentScheduler\ListOfContacts;

/**
 * @param ListOfContacts $contacts_before_encryption
 * @param string $path_to_contacts
 * @param string $path_to_master_key
 * @param string $path_to_stack_of_keys
 * @return void
 */
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
