<?php

namespace StudentAssignmentScheduler\Utils\Functions;

function buildPath(string ...$segments): string
{
    return join(DIRECTORY_SEPARATOR, $segments);
}
