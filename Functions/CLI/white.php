<?php

namespace TalkSlipSender\Functions\CLI;

function white(string $string): string
{
    return "\033[37m${string}" . endColor();
}
