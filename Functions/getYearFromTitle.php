<?php

namespace TalkSlipSender\Functions;

function getYearFromTitle(string $title): string
{
    return dateFromYear(
        parse(
            "/mwbsl(\d{2})/",
            $title
        )
    )->format("Y");
}
