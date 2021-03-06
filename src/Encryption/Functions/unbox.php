<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Encryption\Functions;

/**
 * Decrypt and read sensitive data.
 *
 * @param string $path_to_sensitive_data
 * @param string $key
 * @param $associated_data
 * @return mixed
 */
function unbox(
    string $path_to_sensitive_data,
    string $key,
    string $associated_data = "studentassignmentscheduler"
) {
    return wakeup(
        decrypt(
            \base64_decode(
                \file_get_contents(
                    $path_to_sensitive_data
                )
            ),
            $associated_data,
            $key
        )
    );
}
