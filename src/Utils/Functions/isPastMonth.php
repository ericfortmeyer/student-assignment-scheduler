<?php declare(strict_types=1);

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
