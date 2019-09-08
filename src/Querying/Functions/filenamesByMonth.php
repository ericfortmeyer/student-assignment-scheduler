<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use function StudentAssignmentScheduler\Utils\Functions\monthNumeric;
use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;


function filenamesByMonth(string $month, string $path_to_files): array
{
    return array_filter(
        filenamesInDirectory($path_to_files),
        function (string $filename) use ($month) {
            return firstTwoCharacters($filename) === monthNumeric($month);
        }
    );
}

function firstTwoCharacters(string $text): string
{
    return str_split($text, 2)[0];
}
