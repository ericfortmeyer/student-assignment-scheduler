<?php

namespace TalkSlipSender\Functions\CLI;

function shouldUseNextMonth(string $key, int $day_of_month): bool
{
    return $key > 3 && $day_of_month < 7;
}
