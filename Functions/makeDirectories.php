<?php

namespace StudentAssignmentScheduler\Functions;

function makeDirectories(array $directories): void
{
    array_map(
        function (string $directory) {
            !file_exists($directory)
                && mkdir($directory, 0777, true);
        },
        $directories
    );
}
