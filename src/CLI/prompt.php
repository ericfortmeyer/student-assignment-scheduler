<?php

namespace StudentAssignmentScheduler\CLI;

function prompt(string $message): string
{
    return "${message}?(Y/N)";
}
