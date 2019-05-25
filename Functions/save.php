<?php

namespace StudentAssignmentScheduler\Functions;

use function StudentAssignmentScheduler\Functions\Logging\fileSaveLogger;
use function StudentAssignmentScheduler\Functions\Logging\nullLogger;
use function StudentAssignmentScheduler\FileRegistry\Functions\registerFile;

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
