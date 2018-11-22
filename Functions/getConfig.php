<?php

namespace TalkSlipSender\Functions;

function getConfig(): array
{
    return require __DIR__ . "/../config/config.php";
}
