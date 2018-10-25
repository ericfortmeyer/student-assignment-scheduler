<?php

namespace TalkSlipSender\Functions;

function dateFromYear(string $date): object
{
    return date_create_from_format("y", $date);
}
