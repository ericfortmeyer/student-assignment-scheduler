<?php

namespace TalkSlipSender\Functions;

function decryptedPassword(): string
{
    return sodium_crypto_secretbox_open(
        getenv("from_email_password"),
        getenv("from_email_nonce"),
        getenv("from_email_key")
    );
}
