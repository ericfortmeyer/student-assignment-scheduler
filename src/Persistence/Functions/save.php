<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Persistence\Functions;

use function StudentAssignmentScheduler\Logging\Functions\{
    fileSaveLogger,
    nullLogger
};
use function StudentAssignmentScheduler\FileRegistry\Functions\{
    registerFile,
    hashOfFile
};

/**
 * @param object|array $file_data
 * @param string $filename
 * @param bool $test_mode
 * @param string|null $test_registry
 */
function save(
    $file_data,
    string $filename,
    bool $test_mode = false,
    ?string $test_registry = null
): void {

    $logger = whichLogger(__FUNCTION__, $test_mode);
    $directory = dirname($filename);

    !file_exists($directory) && makeDir($directory, $logger);
    !file_exists($filename) && createFile($file_data, $filename, $logger, $test_registry);
}

function makeDir(string $directory, $logger)
{
    $context = ["directory" => $directory];

    mkdir($directory, 0777, true)
        ? $logger->info("Directory {directory} created", $context)
        : $logger->error("Directory {directory} creation failed", $context);
}

function success(string $filename, $logger, array $context, ?string $test_registry)
{
    $test_registry
        ? registerFile(hashOfFile($filename), $filename, $test_registry)
        : registerFile(hashOfFile($filename), $filename);

    $logger->info("File {file} created", $context);
}

function fail($logger, array $context)
{
    $logger->error("File {file} creation failed", $context);
}

function whichLogger(string $function, bool $test_mode)
{
    return $test_mode ? nullLogger() : fileSaveLogger($function);
}
