<?php

namespace TalkSlipSender\Functions;

function getDateFromWorkbookPath(string $path): object
{
    return date_create_from_format(
        "Ym",
        preg_split(
            "/ASL_/",
            pathinfo($path, PATHINFO_FILENAME)
        )[1]
    );
}
