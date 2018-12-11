<?php

namespace TalkSlipSender\Functions;

function getAssignment(int $assignment_number, string $text): string
{
    $string_representation_of_media_image_for_videos = "w";
    
    // example: 5 Initial Call (
    $pattern = "/(?# newline)[\n]"
        // the numeric representation of the assignment
        . "${assignment_number}"
        . "(?# one or more horizontal whitespaces)[\h]"
        . "(?# capture if one or more non numerical characters)([^0-9]+)"
        . "(?# one or more horizontal whitespaces)[\h]"
        . "(?# one open parentheses)\(/";

    $result = ltrim(
            parse(
                $pattern,
                $text
            ),
            $string_representation_of_media_image_for_videos
        );

    return $result === "Ta l k"
        ? str_replace(" ", "", $result)
        : $result;
}
