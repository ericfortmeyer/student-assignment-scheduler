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

use \DateInterval;

function getAssignmentDate(string $pattern, string $text, string $month, string $interval_spec): string
{
    return date_create_immutable_from_format(
        "F d",
        "$month " . parse(
            $pattern,
            $text
        )
    )->add(new DateInterval($interval_spec))->format("d");
}
