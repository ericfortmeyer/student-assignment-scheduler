<?php

namespace StudentAssignmentScheduler\FileRegistry\Functions;

function registerFile(string $key, string $filename, string $registry_filename = __DIR__ . "/../registry.php")
{
    !file_exists($registry_filename)
        && generateRegistry([], $registry_filename);
    $registry = include $registry_filename;
    generateRegistry(
        array_merge($registry, [$key => $filename]),
        $registry_filename ?? ""
    );
}
