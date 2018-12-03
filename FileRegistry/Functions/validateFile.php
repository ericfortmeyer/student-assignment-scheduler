<?php

namespace TalkSlipSender\FileRegistry\Functions;

function validateFile(string $hash, string $path, ?string $registry_filename = null): bool
{
    $registry = include $registry_filename ?? __DIR__ . "/../registry.php";

    return key_exists($hash, $registry) && $registry[$hash] === $path;
}
