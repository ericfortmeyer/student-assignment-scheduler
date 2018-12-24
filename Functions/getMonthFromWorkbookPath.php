<?php

namespace StudentAssignmentScheduler\Functions;

function getMonthFromWorkbookPath(string $path): string
{
    return getDateFromWorkbookPath($path)->format("F");
}
