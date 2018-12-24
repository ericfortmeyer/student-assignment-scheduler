<?php

namespace StudentAssignmentScheduler\Functions\Logging;

use Psr\Log\LoggerInterface;

function emailLogger(string $function_name = ""): LoggerInterface
{
    return logger("email", $function_name);
}
