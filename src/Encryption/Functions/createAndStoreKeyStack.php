<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Encryption\Functions;

use \Ds\Stack;

/**
 * @param string $path_to_store_key_stack
 * @param string $master_key
 * @param string[] $keys
 * @return void
 */
function createAndStoreKeyStack(
    string $path_to_store_key_stack,
    string $master_key,
    array $keys = []
): void {
    $keysOrDefault = !empty($keys) ? $keys : [random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES)];
    $KeyStack = new Stack();
    foreach ($keysOrDefault as $key) {
        $KeyStack->push($key);
    }
    box(
        $KeyStack,
        $path_to_store_key_stack,
        $master_key
    );

    chmod($path_to_store_key_stack, 0600);
}
