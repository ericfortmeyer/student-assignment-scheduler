<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Logging\Functions;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\LoggerInterface;

function logger(string $log_type, string $function_name = ""): LoggerInterface
{
    $log_config = require __DIR__ . "/../log_config.php";
    $log_file = $log_config["${log_type}_log"];
    $log = new Logger($function_name);
    $log->pushHandler(new StreamHandler($log_file));
    $log->pushProcessor(new PsrLogMessageProcessor());

    return $log;
}
