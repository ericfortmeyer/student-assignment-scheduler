<?php declare(strict_types=1);

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
