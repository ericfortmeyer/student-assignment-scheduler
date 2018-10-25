<?php

namespace TalkSlipSender\Functions;

function weeksFrom(array $schedule_for_month): array
{
    return array_filter(
        $schedule_for_month,
        function (string $key) {
            return $key !== "month" && $key !== "year";
        },
        ARRAY_FILTER_USE_KEY
    );
}
