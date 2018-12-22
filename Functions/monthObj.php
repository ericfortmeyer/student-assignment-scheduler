<?php

namespace TalkSlipSender\Functions;

function monthObj(string $month, string $year = null): object
{
    return empty($year)
        ? date_create_from_format("F", $month)
        : date_create_from_format("Y F", "$year $month");
}
