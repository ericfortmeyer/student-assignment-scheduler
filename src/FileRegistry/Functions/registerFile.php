<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
