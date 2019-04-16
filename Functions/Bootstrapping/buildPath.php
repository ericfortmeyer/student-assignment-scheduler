<?php

namespace StudentAssignmentScheduler\Functions\Bootstrapping;

function buildPath(string ...$segments): string
{
    return join(DIRECTORY_SEPARATOR, $segments);
}
