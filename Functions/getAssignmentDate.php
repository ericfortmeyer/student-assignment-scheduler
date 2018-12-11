<?php

namespace TalkSlipSender\Functions;

use \DateInterval;

function getAssignmentDate(string $text, string $month, string $interval_spec): string
{
    // example: JANUARY 10
    $pattern = "/^(?# beginning of line)"
        . strtoupper($month)
        . "(?# one or more horizontal whitespaces)\h+"
        . "(?# capture one or two digits)(\d{1,2})"
        . "(?# multiline mode)/m";
    
    return date_create_immutable_from_format(
        "F d",
        "$month " . parse(
            $pattern,
            $text
        )
    )->add(new DateInterval($interval_spec))->format("d");
}
