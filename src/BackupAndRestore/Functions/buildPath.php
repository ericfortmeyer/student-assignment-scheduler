<?php

namespace StudentAssignmentScheduler\BackupAndRestore\Functions;

function buildPath(string ...$segments): string
{
    return join(DIRECTORY_SEPARATOR, $segments);
}
