<?php

namespace StudentAssignmentScheduler\Functions\Filenaming;

use StudentAssignmentScheduler\Classes\Destination;

use function StudentAssignmentScheduler\Functions\Bootstrapping\buildPath;

use \DateTimeImmutable;

function jsonAssignmentCopyFilename(
    Destination $destination,
    DateTimeImmutable $date_time,
    string $original_file_basename
): string {
    return buildPath("${destination}", "{$date_time->format(DateTimeImmutable::RFC3339)}_${original_file_basename}");
}
