<?php

namespace TalkSlipSender\Functions\CLI;

function yellow(string $string): string
{
    return "\033[36m${string}" . endColor();
}
