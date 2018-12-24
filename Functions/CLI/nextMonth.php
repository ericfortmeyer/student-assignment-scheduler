<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function nextMonth(string $month): string
{
    return date_create_from_format("F", $month)
        ->add(new \DateInterval("P1M"))
        ->format("F");
}
