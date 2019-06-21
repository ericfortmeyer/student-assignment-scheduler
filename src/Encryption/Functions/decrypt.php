<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Encryption\Functions;

/**
 * @param string $ciphertext
 * @param string $ad Associated Data
 * @param string $key
 * @return string
 */
function decrypt(string $ciphertext, string $ad, string $key): string
{
    $nonce = mb_substr($ciphertext, 0, 24, '8bit');
    $message = mb_substr($ciphertext, 24, null, '8bit');
    return \sodium_crypto_aead_xchacha20poly1305_ietf_decrypt(
        $message,
        $ad,
        $nonce,
        $key
    );
}
