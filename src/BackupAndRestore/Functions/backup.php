<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore\Functions;

use StudentAssignmentScheduler\BackupAndRestore\BackupConfig;

function backup(BackupConfig $config, string $backupFileBasenameForTesting = ""): array
{
    $zip = $config->initZip($backupFileBasenameForTesting);

    $config->addFilesToZip($zip);

    $config->addDirectoriesRecursivelyToZip($zip);

    $filename = $zip->filename;
    $result = $zip->close();
    return [$filename, $result];
}
