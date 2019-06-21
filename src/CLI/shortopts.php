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

function shortopts(array $opts)
{
    return array_reduce(
        $opts,
        function (?string $carry, array $pair) {
            return $carry ? "${carry}$pair[0]" : "$pair[0]";
        }
    );
}
