<?php

namespace StudentAssignmentScheduler\Functions\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\LoggerInterface;

function logger(string $log_type, string $function_name = ""): LoggerInterface
{
    $log_config = require __DIR__ . "/log_config.php";
    $log_file = $log_config["${log_type}_log"];
    $log = new Logger($function_name);
    $log->pushHandler(new StreamHandler($log_file));
    $log->pushProcessor(new PsrLogMessageProcessor());

    return $log;
}
