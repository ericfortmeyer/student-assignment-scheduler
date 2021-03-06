<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

function getMonthFromWorkbookPath(string $path): string
{
    return getDateFromWorkbookPath($path)->format("F");
}
