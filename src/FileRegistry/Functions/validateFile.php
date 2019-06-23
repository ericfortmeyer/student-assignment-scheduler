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

function validateFile(string $hash, string $path, ?string $registry_filename = null): bool
{
    $registry = include $registry_filename ?? __DIR__ . "/../registry.php";

    return key_exists($hash, $registry) && $registry[$hash] === $path;
}
