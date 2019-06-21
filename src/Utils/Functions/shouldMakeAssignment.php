<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\Utils\Functions;

use function StudentAssignmentScheduler\Utils\Functions\getConfig;

function shouldMakeAssignment(string $assignment_name): bool
{
    $assignments_that_should_be_skipped = getConfig()["skip_assignments_with_these_titles"];

    $shouldNotBeSkipped = !in_array($assignment_name, $assignments_that_should_be_skipped);
    $isNotAVideoPresentation = doesNotHaveWordVideo($assignment_name);

    return $isNotAVideoPresentation && $shouldNotBeSkipped;
}
