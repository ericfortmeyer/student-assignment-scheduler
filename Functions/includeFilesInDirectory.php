<?php

namespace StudentAssignmentScheduler\Functions;

/**
 * Use to automatically include functions
 * Recursively includes files in the given
 * This file and system files are exluded
 */
function includeFilesInDirectory(string $directory)
{
    array_map(
        function (string $filename) use ($directory) {
            is_dir("${directory}/${filename}")
                ? includeFilesInDirectory("${directory}/${filename}")
                : require_once "${directory}/${filename}";
        },
        array_diff(
            scandir($directory),
            [".", "..", ".DS_Store", basename(__FILE__)]
        )
    );
}
