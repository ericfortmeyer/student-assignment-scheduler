<?php

namespace StudentAssignmentScheduler\Persistence\Functions;

use Psr\Log\LoggerInterface;

use function StudentAssignmentScheduler\FileRegistry\Functions\registerFile;

/**
 * @param object|array $file_data
 * @param string $filename
 * @param LoggerInterface $logger
 * @param string|null $test_registry
 */
function createFile($file_data, string $filename, LoggerInterface $logger, ?string $test_registry = null)
{
    $context = ["file" => $filename];

    file_put_contents($filename, json_encode($file_data, JSON_PRETTY_PRINT))
        ? fileCreateSuccess($filename, $logger, $context, $test_registry)
        : fileCreateFailed($logger, $context);
}

function fileCreateSuccess(string $filename, LoggerInterface $logger, array $context, ?string $test_registry)
{
    $test_registry
        ? registerFile(hashOfFile($filename), $filename, $test_registry)
        : registerFile(hashOfFile($filename), $filename);

    $logger->info("File {file} created", $context);
}

function fileCreateFailed($logger, array $context)
{
    $logger->error("File {file} creation failed", $context);
}
