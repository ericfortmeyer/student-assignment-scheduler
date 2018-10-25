<?php

namespace TalkSlipSender\Functions;

function getAssignment(int $number, string $text): string
{
    $string_representation_of_media_image_for_videos = "w";

    $result = ltrim(
        parse(
            "/[\n]${number}[\t]+([^0-9]+)[\h]+\(/",
            $text
        ),
        $string_representation_of_media_image_for_videos
    );

    return $result === "Ta l k"
        ? str_replace(" ", "", $result)
        : $result;
}
