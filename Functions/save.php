<?php

namespace StudentAssignmentScheduler\Functions;

use function StudentAssignmentScheduler\Functions\Logging\fileSaveLogger;
use function StudentAssignmentScheduler\Functions\Logging\nullLogger;
use function StudentAssignmentScheduler\FileRegistry\Functions\registerFile;

function save(
    array $file_data,
    string $filename,
    bool $test_mode = false,
    ?string $test_registry = null
): void {

    $logger = whichLogger(__FUNCTION__, $test_mode);
    $directory = dirname($filename);

    !file_exists($directory) && makeDir($directory, $logger);
    !file_exists($filename) && createFile($file_data, $filename, $logger, $test_registry);
}

function createFile(array $file_data, string $filename, $logger, ?string $test_registry)
{
    $context = ["file" => $filename];

    file_put_contents($filename, json_encode($file_data, JSON_PRETTY_PRINT))
        ? success($filename, $logger, $context, $test_registry)
        : fail($logger, $context);
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
        ? registerFile(hashOfFile($filename), $filename, $test_registry): registerFile(hashOfFile($filename), $filename);

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
