<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Functions\Filenaming;

function backupFileBasename(string $basename = ""): string
{
    return $basename ? $basename : (string) time() . ".zip";
}
