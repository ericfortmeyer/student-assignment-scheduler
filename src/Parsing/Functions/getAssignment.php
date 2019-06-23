<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Parsing\Functions;

function getAssignment(string $pattern, string $text): string
{
    $string_representation_of_media_image_for_videos = "w";

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
