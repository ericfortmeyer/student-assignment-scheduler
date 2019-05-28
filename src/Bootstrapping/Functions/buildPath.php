<?php

namespace StudentAssignmentScheduler\Bootstrapping\Functions;

function buildPath(string ...$segments): string
{
    return join(DIRECTORY_SEPARATOR, $segments);
}
