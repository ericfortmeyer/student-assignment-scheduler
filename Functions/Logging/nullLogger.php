<?php

namespace StudentAssignmentScheduler\Functions\Logging;

use Monolog\Logger;
use Monolog\Handler\NullHandler;
use Psr\Log\LoggerInterface;

function nullLogger(): LoggerInterface
{
    $log = new Logger("null");
    $log->pushHandler(new NullHandler());

    return $log;
}
