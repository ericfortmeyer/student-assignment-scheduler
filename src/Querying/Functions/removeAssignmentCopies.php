<?php

namespace StudentAssignmentScheduler\Querying\Functions;

function removeAssignmentCopies(string $filename): bool
{
    // copies have ctime prepended to the filename
    $pattern = "/^[[:digit:]]{2}_[[:digit:]]{4}.json$/";
    $isNotACopy = preg_match($pattern, $filename) == 1;
    return $isNotACopy;
}
