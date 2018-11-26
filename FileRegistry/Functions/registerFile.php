<?php

namespace TalkSlipSender\FileRegistry\Functions;

function registerFile(string $key, string $filename, ?string $registry_filename = null)
{
    $registry_filename && !file_exists($registry_filename) && generateRegistry([], $registry_filename);

    $registry = include $registry_filename ?? __DIR__ . "/../registry.php";

    generateRegistry(
        array_merge($registry, [$key => $filename]),
        $registry_filename ?? ""
    );
}
