<?php

namespace TalkSlipSender\Functions;

use \DateInterval;

function getAssignmentDate(string $text, string $month, string $interval_spec): string
{
    $monthAllCaps = strtoupper($month);

    list(
        $beginning_of_line,
        $one_or_more_horizontal_whitespaces,
        $one_or_two_digits_captured,
        $multiline_mode
    ) = ["/^", "\h+", "(\d{1,2})", "/m"];

    $pattern = $beginning_of_line
        . $monthAllCaps
        . $one_or_more_horizontal_whitespaces
        . $one_or_two_digits_captured
        . $multiline_mode;

    return date_create_immutable_from_format(
        "F d",
        "$month " . parse(
            $pattern,
            $text
        )
    )->add(new DateInterval($interval_spec))->format("d");
}
