<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

function checkFilteredReply(
    string $filtered_reply,
    string $user_input,
    string $input_type,
    \Closure $ui_func,
    string $prompt
): string {
    if (!$filtered_reply) {
        $input_type_formatted = str_replace("_", " ", $input_type);
        $prompt = red("Oops! $user_input is not what is expected for $input_type_formatted") . PHP_EOL
            . $prompt;
        $tuple = $ui_func($prompt, $input_type);
        $user_input = $tuple[0];
        $filtered_reply = $tuple[1];

        return checkFilteredReply(
            $filtered_reply,
            $user_input,
            $input_type,
            $ui_func,
            $prompt
        );
    } else {
        return $filtered_reply;
    }
}
