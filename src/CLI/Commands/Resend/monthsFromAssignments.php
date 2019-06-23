<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\Resend;

use \Ds\Set;
use \Ds\Map;

/**
 * Create a set of unique months extracted from the data
 * in a map of assignments.
 *
 * @param Map $assignments
 * @return Set
 */
function monthsFromAssignments(Map $assignments): Set
{
    return $assignments->reduce(
        function (Set $carry, $key, array $assignment): Set {
            $month = explode(" ", $assignment["date"])[0];
            $carry->add($month);
            return $carry;
        },
        new Set()
    );
}
