<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

function no(string $reply): bool
{
    list($yes, $no) = [["y", "Y", "yes", "Yes", "YES"],["n", "N", "no", "No", "NO"]];
    return in_array($reply, $no);
}
