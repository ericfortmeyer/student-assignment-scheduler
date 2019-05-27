<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use function StudentAssignmentScheduler\FileRegistry\Functions\{
    validateFile,
    hashOfFile
};
use function StudentAssignmentScheduler\Logging\Functions\{
    fileSaveLogger,
    nullLogger
};

function importJson(string $path_to_json, bool $test_mode = false, ?string $test_registry = null): array
{

    $logger = whichLogger(__FUNCTION__, $test_mode);
    $context = ["file" => $path_to_json];

    try {
        validateFile(hashOfFile($path_to_json), $path_to_json, $test_registry);
    } catch (\Exception $e) {
        fileInvalidAction($path_to_json, $logger, $context);
    }

    return fileValidAction($path_to_json, $logger, $context);
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

/**
 * What to do if the file is invalid
 *
 * @param string $path The path of the invalid file.  Needed for error handling and loggin
 * @param array $context
 * @return void
 * @throws \Exception
 */
function fileInvalidAction(string $path, $logger, array $context): void
{
    $logger->critical("FILE {file} invalid", $context);
    throw new \Exception("File ${path} invalid");
}

function whichLogger(string $function, bool $test_mode)
{
    return $test_mode ? nullLogger() : fileSaveLogger($function);
}
