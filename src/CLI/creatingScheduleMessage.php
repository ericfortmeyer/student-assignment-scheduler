<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

function creatingScheduleMessage(string $month): string
{
    $line = purple("********************************") . "\r\n";
    return "${line}Creating Schedule For " . white($month) . "\r\n${line}";
}
