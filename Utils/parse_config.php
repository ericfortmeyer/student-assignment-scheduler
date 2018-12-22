<?php

$exclude_from_assignment_lookup = [
    "Digging for Spiritual Gems",
    "Bible Reading",
    "Congregation Bible Study",
    "Annual Service Report"
];
$titles_to_exclude = implode("|", $exclude_from_assignment_lookup);

return [
    "interval_spec" => [
        "Monday" => "P0D",
        "Tuesday" => "P1D",
        "Wednesday" => "P2D",
        "Thursday" => "P3D",
        "Friday" => "P4D"
    ],
    "pdf_assignment_pattern_func" => function (int $assignment_number): string {
        return "/(?# newline)[\n]"
        . "(?# the numeric representation of the assignment)${assignment_number}"
        . "(?# one or more horizontal whitespaces)[\h]"
        . "(?# capture if one or more non numerical characters)([^0-9]+)"
        . "(?# one or more horizontal whitespaces)[\h]"
        . "(?# one open parentheses)\(/";
    },
    "assignment_date_pattern_func" => function (string $month): string {
        return "/^(?# beginning of line)"
        . strtoupper($month)
        . "(?# one or more horizontal whitespaces)\h+"
        . "(?# capture one or two digits)(\d{1,2})"
        . "(?# multiline mode)/m";
    },
    "rtf_assignment_pattern" => "/(?# text before)\\\b "
        . "(?# start subpattern)(?:"
        . "(?# exclude these)(?!"
        . $titles_to_exclude
        . "(?# closing parentheses))"
        . "(?# capture any number of words)(\w+[\D]*)"
        . "(?# end subpattern))"
        . "(?# semicolon)\:"
        . "/"
];
