<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

use \Ds\Stack;

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
