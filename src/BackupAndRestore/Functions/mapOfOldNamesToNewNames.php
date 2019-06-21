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

use StudentAssignmentScheduler\BackupAndRestore\{
    File,
    RestoreConfig
};
use \Ds\Map;

function mapOfOldNamesToNewNames(RestoreConfig $config): Map
{
    $map = new Map();

    $config->filesInTmpDir()->reduce(
        function ($carry, string $oldname) use ($map, $config) {
            $file = new File($oldname);
            $newname = $config->newNameFromOldName($file);
            recursivelyAddTargetFilenamesToMap(
                $map,
                $config,
                (string) $file,
                $newname
            );
        }
    );

    return $map;
}
