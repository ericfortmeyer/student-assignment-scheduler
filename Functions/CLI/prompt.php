<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function prompt(string $message): string
{
    return "${message}?(Y/N)";
}
