<?php

namespace TalkSlipSender\Functions;

function getAssignment(int $number, string $text): string
{
    $does_not_have_schedule = strlen($text) < 400;
    if ($does_not_have_schedule) {
        return "";
    }
    $string_representation_of_media_image_for_videos = "w";

    list(
        $newline,
        $one_or_more_tabs,
        $capture_if_one_or_more_non_numerical_characters,
        $one_or_more_horizontal_whitespaces,
        $one_open_parentheses
    ) = ["/[\n]", "[\h]+", "([^0-9]+)", "[\h]+", "\(/"];

    $pattern = $newline
        . $number
        . $one_or_more_tabs
        . $capture_if_one_or_more_non_numerical_characters
        . $one_or_more_horizontal_whitespaces
        . $one_open_parentheses;

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
