<?php

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
