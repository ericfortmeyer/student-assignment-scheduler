<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function purple(string $string): string
{
    return "\033[35m${string}" . endColor();
}
