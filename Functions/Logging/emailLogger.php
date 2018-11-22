<?php

namespace TalkSlipSender\Functions\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\LoggerInterface;

use function TalkSlipSender\Functions\getConfig;

function emailLogger(string $function_name = ""): LoggerInterface {
    $email_log_file = getConfig()["email_log"];
    $log = new Logger($function_name);
    $log->pushHandler(new StreamHandler($email_log_file));
    $log->pushProcessor(new PsrLogMessageProcessor());

    return $log;
}
