<?php

namespace StudentAssignmentScheduler\Parsing\Functions;

use function StudentAssignmentScheduler\Utils\Functions\getConfig;

function getYearFromTitle(string $title): string
{
    $config = getConfig();
    $language = $config["language"];
    $mnemonic = $config["mnemonic"][$language];
    return dateFromYear(
        parse(
            "/$mnemonic(\d{2})/",
            $title
        )
    )->format("Y");
}
