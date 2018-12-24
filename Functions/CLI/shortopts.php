<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function shortopts(array $opts)
{
    return array_reduce(
        $opts,
        function (?string $carry, array $pair) {
            return $carry ? "${carry}$pair[0]" : "$pair[0]";
        }
    );
}
