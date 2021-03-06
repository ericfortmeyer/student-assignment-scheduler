<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Encryption\Functions;

/**
 * @param string $path_to_store_master_key
 * @return void
 */
function createAndStoreMasterKey(string $path_to_store_master_key): void
{
    /**
     * we are not using the box function here since this is the master key
     */
    \file_put_contents(
        $path_to_store_master_key,
        \base64_encode(
            random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES)
        )
    );

    chmod($path_to_store_master_key, 0600);
}
