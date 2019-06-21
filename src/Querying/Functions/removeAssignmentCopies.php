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

function removeAssignmentCopies(string $filename): bool
{
    // copies have ctime prepended to the filename
    $pattern = "/^[[:digit:]]{2}_[[:digit:]]{4}.json$/";
    $isNotACopy = preg_match($pattern, $filename) == 1;
    return $isNotACopy;
}
