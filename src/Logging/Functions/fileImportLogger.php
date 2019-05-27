<?php

namespace StudentAssignmentScheduler\Logging\Functions;

use Psr\Log\LoggerInterface;

function fileImportLogger(string $function_name = ""): LoggerInterface
{
    return logger("file_import", $function_name);
}
