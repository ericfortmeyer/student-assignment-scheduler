<?php

namespace StudentAssignmentScheduler\Querying\Functions;

function getAppVersion(): string
{
    return exec("git describe --abbrev=0 &>/dev/null");
}
