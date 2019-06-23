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

function weeksFrom(array $schedule_for_month): array
{
    return array_filter(
        $schedule_for_month,
        function (string $key) {
            return $key !== "month" && $key !== "year";
        },
        ARRAY_FILTER_USE_KEY
    );
}
