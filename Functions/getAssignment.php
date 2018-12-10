<?php

namespace TalkSlipSender\Functions;

function getAssignment(int $number, string $text): string
{
    $does_not_have_schedule = strlen($text) < 400;
    if ($does_not_have_schedule) {
        return "";
    }
    $string_representation_of_media_image_for_videos = "w";

    $pattern = "/(?# newline)[\n]"
        . "(?# one or more tabs)[\h]"
        . "(?# capture if one or more non numerical characters)([^0-9]+)"
        . "(?# one or more horizontal whitespaces)[\h]"
        . "(?# one open parentheses\(/";

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
