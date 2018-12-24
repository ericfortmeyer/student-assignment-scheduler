<?php

namespace StudentAssignmentScheduler\Functions;

use function StudentAssignmentScheduler\FileRegistry\Functions\validateFile;

function importJson(string $path_to_json, bool $test_mode = false, ?string $test_registry = null): array
{

    $logger = whichLogger(__FUNCTION__, $test_mode);
    $context = ["file" => $path_to_json];
    
    return validateFile(hashOfFile($path_to_json), $path_to_json, $test_registry)
            ? fileValidAction($path_to_json, $logger, $context)
            : fileInvalidAction($path_to_json, $logger, $context);
}

function fileValidAction(string $path, $logger, array $context)
{
    $logger->info("FILE {file} imported", $context);
    return json_decode(
        file_get_contents(
            $path
        ),
        true
    );
}

function fileInvalidAction(string $path, $logger, array $context)
{
    $logger->critical("FILE {file} invalid", $context);
    return [];
}
