<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

function getYearFromWorkbookPath(string $path): string
{
    return getDateFromWorkbookPath($path)->format("Y");
}
