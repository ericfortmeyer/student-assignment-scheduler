<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Encryption\Functions;

/**
 * Encrypt and persist sensitive data.
 *
 * @param mixed $sensitive_data
 * @param string $path_to_sensitive_data
 * @param string $key
 * @param string $associated_data
 * @return void
 */
function box(
    $sensitive_data,
    string $path_to_sensitive_data,
    string $key,
    string $associated_data = "studentassignmentscheduler"
): void {
    \file_put_contents(
        $path_to_sensitive_data,
        \base64_encode(
            encrypt(
                flatten($sensitive_data),
                $key,
                $associated_data
            )
        ),
        LOCK_EX
    );
}
