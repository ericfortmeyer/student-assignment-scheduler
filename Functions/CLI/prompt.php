<?php

namespace TalkSlipSender\Functions\CLI;

function prompt(string $message): string
{
    return "\033[37m${message}?(Y/N)" . endColor();
}
