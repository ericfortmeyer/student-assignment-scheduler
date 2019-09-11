<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
