<?php

namespace StudentAssignmentScheduler\Logging\Functions;

use Psr\Log\LoggerInterface;

function fileSaveLogger(string $function_name = ""): LoggerInterface
{
    return logger("file_save", $function_name);
}
