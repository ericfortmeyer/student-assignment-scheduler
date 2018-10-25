<?php

namespace TalkSlipSender\Functions\CLI;

function red(string $string): string
{
    return "\033[31m${string}" . endColor();
}
