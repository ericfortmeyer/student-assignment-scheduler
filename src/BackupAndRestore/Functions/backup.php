<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

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
