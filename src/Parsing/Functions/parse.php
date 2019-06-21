<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Parsing\Functions;

function parse(string $pattern, string $subject): string
{
    return preg_split(
        $pattern,
        $subject,
        null,
        PREG_SPLIT_DELIM_CAPTURE
    )[1];
}
