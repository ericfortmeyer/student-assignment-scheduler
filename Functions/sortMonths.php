<?php

namespace StudentAssignmentScheduler\Functions;

function sortMonths(array $months): array
{
    usort(
        $months,
        function ($a, $b) {
            return monthObj($a["month"]) <=> monthObj($b["month"]);
        }
    );

    return $months;
}
