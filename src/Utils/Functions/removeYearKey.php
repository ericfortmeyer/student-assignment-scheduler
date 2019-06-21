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

use \Ds\{
    Vector,
    Map
};

function removeYearKey(array $monthOfAssignments): array
{
    return (new Vector($monthOfAssignments))->map(function (array $weekOfAssignments): array {
        return (new Map($weekOfAssignments))->filter(
            function ($key, $value) {
                return $key !== "year";
            }
        )->toArray();
    })->toArray();
}
