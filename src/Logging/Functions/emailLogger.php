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

use Psr\Log\LoggerInterface;

function emailLogger(string $function_name = ""): LoggerInterface
{
    return logger("email", $function_name);
}
