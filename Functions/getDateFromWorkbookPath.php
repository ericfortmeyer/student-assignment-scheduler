<?php

namespace TalkSlipSender\Functions;

function getDateFromWorkbookPath(string $path): object
{
    $config = getConfig();
    $language = $config["language"];
    $worksheet_prefix = $config["worksheet_filename_prefix"][$language];
    return date_create_from_format(
        "Ym",
        preg_split(
            "/$worksheet_prefix(\d{6})/",
            pathinfo($path, PATHINFO_FILENAME),
            null,
            PREG_SPLIT_DELIM_CAPTURE
        )[1]
    );
}
