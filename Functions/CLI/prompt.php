<?php

namespace TalkSlipSender\Functions\CLI;

function prompt(string $message): string
{
    return white("${message}?(Y/N)");
}
