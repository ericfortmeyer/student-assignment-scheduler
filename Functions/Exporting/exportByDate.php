<?php

namespace StudentAssignmentScheduler\Functions\Exporting;

use \Ds\Map;

function exportByDate(string $date, \Closure $getSourceDirectory, Map $dest): void
{
    list(
        $year,
        $month,
        $day
    ) = explode("-", $date);

    exportFiles(
        ["$month$day.json"],
        $getSourceDirectory($year),
        $dest
    );
}
