<?php declare(strict_types=1);

function generateXSRFToken(string $value_to_hash): string {
    return base64_encode(
        sodium_crypto_generichash($value_to_hash, getSecretKey())
    );
}
