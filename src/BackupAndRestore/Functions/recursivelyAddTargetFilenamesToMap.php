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
    RestoreConfig,
    Directory
};
use \Ds\Map;

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
