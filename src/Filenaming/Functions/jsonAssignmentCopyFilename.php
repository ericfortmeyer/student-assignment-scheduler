<?php

namespace StudentAssignmentScheduler\Filenaming\Functions;

use StudentAssignmentScheduler\Destination;

use \DateTimeImmutable;

function jsonAssignmentCopyFilename(
    Destination $destination,
    DateTimeImmutable $date_time,
    string $original_file_basename
): string {
    return "${destination}" . DIRECTORY_SEPARATOR . "{$date_time->format(DateTimeImmutable::RFC3339)}_${original_file_basename}";
}
