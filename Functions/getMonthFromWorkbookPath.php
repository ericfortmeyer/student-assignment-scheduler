<?php

namespace TalkSlipSender\Functions;

function getMonthFromWorkbookPath(string $path): string
{
    return getDateFromWorkbookPath($path)->format("F");
}
