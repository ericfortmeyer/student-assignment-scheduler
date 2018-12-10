<?php

namespace TalkSlipSender\Functions;

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
