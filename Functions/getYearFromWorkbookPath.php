<?php

namespace TalkSlipSender\Functions;

function getYearFromWorkbookPath(string $path): string
{
    return getDateFromWorkbookPath($path)->format("Y");
}
