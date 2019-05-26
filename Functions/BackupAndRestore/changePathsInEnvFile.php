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
function changePathsInEnvFile(string $path_to_env_file, string $replacement_path)
{
    $contents_of_env_file = file_get_contents(
        $path_to_env_file
    );
    $key_value_pair = explode(PHP_EOL, $contents_of_env_file)[0];
    $string_to_split = DIRECTORY_SEPARATOR;
    $splitString = explode(
        $string_to_split,
        $key_value_pair
    );
    $key = current($splitString);
    $filename = end($splitString);
    [$blank, $fullpath] = explode(
        $key,
        $contents_of_env_file
    );
    [$path_to_search] = explode(
        $filename,
        $fullpath
    );
    $replace_with = $replacement_path . DIRECTORY_SEPARATOR;
    $new_contents_of_env_file = str_replace(
        $path_to_search,
        $replace_with,
        $contents_of_env_file
    );
    file_put_contents($path_to_env_file, $new_contents_of_env_file);
}
