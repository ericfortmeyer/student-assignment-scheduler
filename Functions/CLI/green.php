<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function green(string $string): string
{
    return "\033[32m${string}" . endColor();
}
