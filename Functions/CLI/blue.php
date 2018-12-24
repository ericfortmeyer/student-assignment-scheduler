<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function blue(string $string): string
{
    return "\033[34m${string}" . endColor();
}
