<?php

namespace StudentAssignmentScheduler\Functions;

function getAppVersion(): string
{
    return exec("git describe --abbrev=0");
}
