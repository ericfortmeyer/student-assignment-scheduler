<?php

namespace StudentAssignmentScheduler\Utils\Functions;

function getConfig(): array
{
    return require buildPath(__DIR__, "..", "..", "..", "config", "config.php");
}
