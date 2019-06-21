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

use \Ds\Vector;

function monthsFromScheduleFilenames(
    string $path_to_json_schedules,
    ?int $year = null,
    bool $do_past_months = false
): array {

    $removeExtension = function (string $filename): string {
        return basename($filename, ".json");
    };
    $sortMonths = function (string $month_a, string $month_b) {
        return monthObj($month_a) <=> monthObj($month_b);
    };
    $removePastMonthsIfRequested = function (string $month) use ($year, $do_past_months): bool {
        return $do_past_months || !isPastMonth($month, $year);
    };
    $addKey = function (string $month): array {
        return ["month" => $month];
    };

    /**
     * Requires key "month" to simplify passing arguments into
     * sortMonths function for other clients
     */
    return (new Vector(filenamesInDirectory($path_to_json_schedules)))
        ->map($removeExtension)
        ->sorted($sortMonths)
        ->filter($removePastMonthsIfRequested)
        ->map($addKey)
        ->toArray();
}
