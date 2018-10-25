<?php

namespace TalkSlipSender\Functions\CLI;

function snakeCaseToUCWords(string $assignment): string
{
    return ucwords(str_replace("_", " ", $assignment));
}
