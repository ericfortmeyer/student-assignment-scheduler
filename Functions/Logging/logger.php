<?php

namespace TalkSlipSender\Functions\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\LoggerInterface;

use function TalkSlipSender\Functions\getConfig;

function logger(string $log_type, string $function_name = ""): LoggerInterface
{
    $log_file = getConfig()["${log_type}_log"];
    $log = new Logger($function_name);
    $log->pushHandler(new StreamHandler($log_file));
    $log->pushProcessor(new PsrLogMessageProcessor());

    return $log;
}
