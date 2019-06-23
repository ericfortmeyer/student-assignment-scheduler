<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Parsing\Functions;

use function StudentAssignmentScheduler\Utils\Functions\getConfig;

function getDateFromWorkbookPath(string $path): object
{
    $config = getConfig();
    $language = $config["language"];
    $worksheet_prefix = $config["worksheet_filename_prefix"][$language];
    return date_create_from_format(
        "Ym",
        preg_split(
            "/$worksheet_prefix(\d{6})/",
            pathinfo($path, PATHINFO_FILENAME),
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        )[1]
    );
}
