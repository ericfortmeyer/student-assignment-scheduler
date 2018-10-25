<?php

namespace TalkSlipSender\Functions;

function monthNumeric(string $month): string
{
    return monthObj($month)->format("m");
}
