<?php

namespace StudentAssignmentScheduler\Functions;

function decryptedPassword(): string
{
    /**
     * The nonce and key have a required length
     * They are encoded with MIME base64 so that the binary data can be safely transported
     * These values were being truncated when saving the raw binary data
     */
    $nonce = base64_decode(getenv("from_email_nonce"));
    $key = base64_decode(getenv("from_email_key"));
    $encrypted_password = base64_decode(getenv("from_email_password"));

    return sodium_crypto_secretbox_open(
        $encrypted_password,
        $nonce,
        $key
    );
}
