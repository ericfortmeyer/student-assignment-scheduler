<?php

namespace TalkSlipSender\Functions;

function monthObj(string $month): object
{
    return date_create_from_format("F", $month);
}
