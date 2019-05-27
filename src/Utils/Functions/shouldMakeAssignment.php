<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Utils\Functions;

use function StudentAssignmentScheduler\Utils\Functions\getConfig;

function shouldMakeAssignment(string $assignment_name): bool
{
    $assignments_that_should_be_skipped = getConfig()["skip_assignments_with_these_titles"];

    $shouldNotBeSkipped = !in_array($assignment_name, $assignments_that_should_be_skipped);
    $isNotAVideoPresentation = doesNotHaveWordVideo($assignment_name);

    return $isNotAVideoPresentation && $shouldNotBeSkipped;
}
