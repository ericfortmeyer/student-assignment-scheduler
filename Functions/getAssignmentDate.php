<?php

namespace TalkSlipSender\Functions;

use \DateInterval;

function getAssignmentDate(string $text, string $month): string
{
    $month_all_caps = strtoupper($month);

    return date_create_immutable_from_format(
        "d",
        parse(
            "/[\n]+${month_all_caps}\h(\d{1,2})/",
            $text
        )
    )->add(new DateInterval("P3D"))->format("d");
}
