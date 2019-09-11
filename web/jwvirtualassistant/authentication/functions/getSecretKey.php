<?php declare(strict_types=1);

function getSecretKey(): string
{
    return base64_decode(
        file_get_contents(dirname(__DIR__) . "/secrets/key")
    );
}
