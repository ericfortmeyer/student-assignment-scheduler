<?php

namespace TalkSlipSender\Functions;

function splitFullName(string $fullname): array
{
    return explode(" ", $fullname);
}
