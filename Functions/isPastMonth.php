<?php

namespace TalkSlipSender\Functions;

function isPastMonth(string $month): bool
{
    return monthObj($month) < date_create();
}
