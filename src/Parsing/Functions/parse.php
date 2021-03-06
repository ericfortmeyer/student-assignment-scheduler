<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

function parse(string $pattern, string $subject): string
{
    return preg_split(
        $pattern,
        $subject,
        null,
        PREG_SPLIT_DELIM_CAPTURE
    )[1];
}
