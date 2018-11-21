<?php

namespace TalkSlipSender\Functions\Exporting;

use \Ds\Map;
use function TalkSlipSender\Functions\filenamesInDirectory;

function exportByMonth(string $month, string $yearDir, Map $dest): void
{
    exportFiles(
        array_filter(
            filenamesInDirectory($yearDir),
            function (string $filename) use ($month) {
                return str_split($filename, 2)[0] == $month;
            }
        ),
        $yearDir,
        $dest
    );
}