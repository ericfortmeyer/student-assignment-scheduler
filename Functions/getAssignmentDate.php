<?php

namespace StudentAssignmentScheduler\Functions;

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
