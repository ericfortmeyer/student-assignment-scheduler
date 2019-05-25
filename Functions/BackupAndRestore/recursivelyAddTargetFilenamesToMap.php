<?php

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use \Ds\Map;
use StudentAssignmentScheduler\Classes\{
    RestoreConfig,
    Directory
};
use function StudentAssignmentScheduler\Functions\buildPath;

function recursivelyAddTargetFilenamesToMap(Map $map, RestoreConfig $config, string $oldname, string $newname)
{
    is_dir($oldname)
        ? (new Directory($oldname))->files()->reduce(
            function ($carry, string $name_of_file_in_dir) use ($map, $config, $oldname, $newname) {
                $current_directory = $oldname;
                $target_directory = $newname;
                $basename_of_file = basename($name_of_file_in_dir);
                $original_filename = buildPath($current_directory, $basename_of_file);
                $target_filename = buildPath($target_directory, $basename_of_file);
                recursivelyAddTargetFilenamesToMap($map, $config, $original_filename, $target_filename);
            }
        )
        : $map->put($oldname, $newname);

}

