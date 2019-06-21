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

function heading(string $assignment): string
{
    $ucwords_assignment = snakeCaseToUCWords($assignment);
    return "\r\n\033[34mCreating ${ucwords_assignment}\033[0m\r\n";
}
