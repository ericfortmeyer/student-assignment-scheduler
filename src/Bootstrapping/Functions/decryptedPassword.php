<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Bootstrapping\Functions;

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
