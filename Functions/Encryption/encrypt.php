<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

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
