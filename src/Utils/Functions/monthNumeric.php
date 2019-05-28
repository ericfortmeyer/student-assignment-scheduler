<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Utils\Functions;

function monthNumeric(string $month): string
{
    return monthObj($month)->format("m");
}
