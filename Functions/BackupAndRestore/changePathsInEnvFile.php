<?php

namespace StudentAssignmentScheduler\Functions\BackupAndRestore;

use function StudentAssignmentScheduler\Functions\{
    getConfig,
    buildPath
};

use \Ds\Vector;

/**
 * @param string $path_to_env_file
 * @param string $replacement_path
 */
function changePathsInEnvFile(string $path_to_env_file, string $path_to_search, string $replacement_path)
{
    $contents_of_env_file = file_get_contents(
        $path_to_env_file
    );
    $new_contents_of_env_file = str_replace(
        $path_to_search,
        $replacement_path,
        $contents_of_env_file
    );
    file_put_contents($path_to_env_file, $new_contents_of_env_file);
}
