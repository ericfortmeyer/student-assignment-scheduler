<?php

namespace TalkSlipSender\Functions\CLI;

function doesNotHaveWordVideo(string $data): bool
{
    return !preg_match("/\bVideo\b/i", $data);
}
