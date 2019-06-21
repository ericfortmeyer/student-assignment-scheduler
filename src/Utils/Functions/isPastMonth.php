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

/**
 * The option to add the year is necessary since it may be late in the year
 * when comparing January or February for instance
 *
 * @param string $month
 * @param int|null $year
 * @return bool
 */
function isPastMonth(string $month, ?int $year = null): bool
{
    return monthObj($month, (string) $year) <= date_create("00:00");
}
