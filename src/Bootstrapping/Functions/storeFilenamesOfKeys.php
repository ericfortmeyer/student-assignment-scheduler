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

function storeFilenamesOfKeys(array $filenames, string $path_to_env): void
{
    array_map(
        function (string $key, string $filename) use ($path_to_env) {
            \file_put_contents(
                $path_to_env,
                "${key}=${filename}" . PHP_EOL,
                LOCK_EX | FILE_APPEND
            );
        },
        array_keys($filenames),
        $filenames
    );
}
