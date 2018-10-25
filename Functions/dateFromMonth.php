<?php

namespace TalkSlipSender\Functions;

function dateFromMonth(string $date): object
{
    return date_create_from_format("m", $date);
}
