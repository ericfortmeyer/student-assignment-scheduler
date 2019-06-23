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
