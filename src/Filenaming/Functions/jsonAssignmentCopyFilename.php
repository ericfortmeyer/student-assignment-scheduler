<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\FileNaming\Functions;

use StudentAssignmentScheduler\Destination;
use \DateTimeImmutable;

function jsonAssignmentCopyFilename(
    Destination $destination,
    DateTimeImmutable $date_time,
    string $original_file_basename
): string {
    return "${destination}/{$date_time->format(DateTimeImmutable::RFC3339)}_${original_file_basename}";
}
