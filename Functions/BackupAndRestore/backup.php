<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use StudentAssignmentScheduler\Classes\BackupConfig;

function backup(BackupConfig $config, string $backupFilenameForTesting = ""): array
{
    $zip = $config->initZip($backupFilenameForTesting);

    $config->addFilesToZip($zip);

    $config->addDirectoriesRecursivelyToZip($zip);

    $filename = $zip->filename;
    $result = $zip->close();
    return [$filename, $result];
}
