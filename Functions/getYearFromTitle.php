<?php

namespace StudentAssignmentScheduler\Functions;

function getYearFromTitle(string $title): string
{
    $config = getConfig();
    return dateFromYear(
        parse(
            "/{$config["mnemonic"]}(\d{2})/",
            $title
        )
    )->format("Y");
}
