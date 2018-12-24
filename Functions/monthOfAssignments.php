<?php

namespace StudentAssignmentScheduler\Functions;

function monthOfAssignments(string $month): callable
{
    return function (string $path_to_assignments_files) use ($month): array {
        return array_map(
            function (string $filename) use ($month, $path_to_assignments_files) {
                return importJson("$path_to_assignments_files/$filename");
            },
            filenamesByMonth($month, $path_to_assignments_files)
        );
    };
}
