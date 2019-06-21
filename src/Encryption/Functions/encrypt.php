<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Encryption\Functions;

/**
 * @param string $message
 * @param string $key
 * @param string $ad Associated data
 * @return string Encrypted string
 */
function encrypt(
    string $message,
    string $key,
    string $ad = "studentassignmentscheduler"
): string {
    $nonce = \random_bytes(24);
    return $nonce . \sodium_crypto_aead_xchacha20poly1305_ietf_encrypt(
        $message,
        $ad,
        $nonce,
        $key
    );
}
