<?php

namespace StudentAssignmentScheduler\Functions;

function getYearFromWorkbookPath(string $path): string
{
    return getDateFromWorkbookPath($path)->format("Y");
}
