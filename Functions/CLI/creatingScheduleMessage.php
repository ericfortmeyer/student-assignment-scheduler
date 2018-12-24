<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function creatingScheduleMessage(string $month): string
{
    $line = purple("********************************") . "\r\n";
    return "${line}Creating Schedule For " . white($month) . "\r\n${line}";
}
