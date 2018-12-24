<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function jsonScheduleCreationNotification(): \Closure
{
    return function (string $month) {
        print green("Schedule for $month was created") . PHP_EOL . PHP_EOL;
    };
}
