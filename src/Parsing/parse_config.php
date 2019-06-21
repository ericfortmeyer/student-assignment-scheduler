<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

return [
    "interval_spec" => [
        "Monday" => "P0D",
        "Tuesday" => "P1D",
        "Wednesday" => "P2D",
        "Thursday" => "P3D",
        "Friday" => "P4D",
        "Saturday" => "P5D",
        "Sunday" => "P6D"
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
    "rtf_just_text_with_assignments_func" => function (string $stream): string {
        $split_worksheet_from = "Apply Yourself to the Field Ministry";
        $split_worksheet_to = "Living as Christians";
        
        return preg_split(
            "/$split_worksheet_to/",
            preg_split(
                "/$split_worksheet_from/",
                $stream
            )[1]
        )[0];
    },
    "rtf_assignment_pattern" => "/(?# backslash, b, and whitespace)(?<=\\\b )"
        . "(?# at least one word)\w+"
        . "(?# any number of sets of words after a whitespace)(?:\s?\w?)*"
        . "(?# followed by a colon)(?=:)/"
];
