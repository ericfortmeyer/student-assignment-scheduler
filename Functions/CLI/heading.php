<?php

namespace TalkSlipSender\Functions\CLI;

function heading(string $assignment): string
{
    $ucwords_assignment = snakeCaseToUCWords($assignment);
    return "\r\n\033[34mCreating ${ucwords_assignment}\033[0m\r\n";
}
