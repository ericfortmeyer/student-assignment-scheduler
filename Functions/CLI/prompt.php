<?php

namespace TalkSlipSender\Functions\CLI;

function prompt(string $message): string
{
    return "${message}?(Y/N)";
}
