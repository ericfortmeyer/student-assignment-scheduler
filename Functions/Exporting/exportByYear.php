<?php

namespace StudentAssignmentScheduler\Functions\Exporting;

use \Ds\Map;
use function StudentAssignmentScheduler\Functions\filenamesInDirectory;

function exportByYear(string $yearDir, Map $dest): void
{
    exportFiles(
        filenamesInDirectory($yearDir),
        $yearDir,
        $dest
    );
}
