<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

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