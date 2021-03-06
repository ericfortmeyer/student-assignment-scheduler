<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

function getMonthFromTitle(string $title): string
{
    return dateFromMonth(
        parse(
            "/[.]+(\d{2})/",
            $title
        )
    )->format("F");
}
