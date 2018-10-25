<?php

namespace TalkSlipSender\Functions;

function sortMonths(array $months): array
{
    usort(
        $months,
        function ($a, $b) {
            return monthObj($a["month"]) < monthObj($b["month"])
                ? -1
                : 1;
        }
    );

    return $months;
}
