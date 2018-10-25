<?php

namespace TalkSlipSender\Functions;

function dateFromFullYear(string $date): object
{
    return date_create_from_format("Y", $date);
}
