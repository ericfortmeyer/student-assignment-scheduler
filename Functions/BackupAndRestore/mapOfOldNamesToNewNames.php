<?php

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use \Ds\Map;
use StudentAssignmentScheduler\Classes\{
    File,
    RestoreConfig
};

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
