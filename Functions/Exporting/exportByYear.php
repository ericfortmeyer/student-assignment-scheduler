<?php

namespace TalkSlipSender\Functions\Exporting;

use \Ds\Map;
use function TalkSlipSender\Functions\filenamesInDirectory;

function exportByYear(string $yearDir, Map $dest): void
{
    exportFiles(
        filenamesInDirectory($yearDir),
        $yearDir,
        $dest
    );
}
